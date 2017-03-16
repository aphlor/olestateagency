var chatSessionId
  , lastEventId
  , pollBlock = false
  , pollTimer
  , userData
  , remoteUser = 'Staff User'
  , chatActive = false
  , activatedEvents = false

var chatTemplate = '\
<div class="panel panel-##MSGINOUT##" id="msg-##MSGID##">\
    <div class="panel-heading">##MSGID-HEAD##</div>\
    <div class="panel-body">##MSGID-BODY##</div>\
</div>\
'

var htmlEncode = function (val) {
    return $('<div/>').text(val).html()
}

var pollForMessages = function () {
    if (pollBlock) {
        return
    }

    // block polling until the ajax event has returned
    pollBlock = true
    $.ajax({
        url: '/contact/chat/poll',
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
            'chatSessionId': chatSessionId,
            'checkpoint': lastEventId
        }
    }).done(function (data, status, xhr) {
        pollBlock = false
        remoteUser = data.participant_name

        // handle enabling/disabling the chat session
        if (data.active) {
            $("#chat-message").attr("disabled", false)
            chatActive = true

            if (!activatedEvents) {
                activateMessageTriggers()
                $("#chat-meta").html("You are connected to <strong>" + remoteUser + "</strong>")
                activatedEvents = true
            }
        } else {
            $("#chat-message").attr("disabled", true)
            chatActive = false
        }

        $.each(data.events, function (position, event) {
            console.log('handling event render (position ' + position + '):')
            console.log(event)

            if ((event.id > lastEventId) || (typeof lastEventId === 'undefined')) {
                lastEventId = event.id
            }

            var chatEntry = chatTemplate
            chatEntry = chatEntry.replace(/##MSGINOUT##/, event.from_initiator ? 'info' : 'success')
            chatEntry = chatEntry.replace(/##MSGID##/, event.id)
            chatEntry = chatEntry.replace(/##MSGID-HEAD##/, event.from_initiator ? htmlEncode(userData.display_name) : htmlEncode(remoteUser))
            chatEntry = chatEntry.replace(/##MSGID-BODY##/, htmlEncode(event.message_text))

            // inject the chatEntry to the page
            $("#chat-area").append(chatEntry)

            // move back to the chat entry box
            $("html, body").animate({
                scrollTop: $("#chat-entry").offset().top
            }, 'slow')

            // console.log(chatEntry)
        })
    })

    // start the polling agent
    pollTimer = setTimeout(pollForMessages, 1000)
}

var activateMessageTriggers = function () {
    // session is setup now, so enable the send/enter actions
    $('#msg-send').click(function (event) {
        // do nothing if the chat is not yet active
        if (!chatActive) {
            return
        }

        // obtain and clear the contents of the text box
        var msg = $('#chat-message').val()
        $('#chat-message').val('')

        // trigger an ajax send
        $.ajax({
            url: '/contact/chat/send',
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                'chatSessionId': chatSessionId,
                'message': msg
            }
        }).done(function (data, status, xhr) {
            // we _could_ advance after sending, but this way we can render back from poll()
            // lastEventId = data.messageId
            console.log('sent message ' + data.messageId)
        })
    })

    $('#chat-message').keypress(function (event) {
        if (event.keyCode == 13) {
            event.preventDefault()
            $('#msg-send').click()
        }
    })
}

$(document).ready(function () {
    // initiate a chat session
    $.ajax({
        url: '/contact/chat/setup',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    }).done(function (data, status, xhr) {
        userData = data.user
        chatSessionId = data.chat_session_id

        // poll immediately for messages
        pollForMessages()
    })
})
