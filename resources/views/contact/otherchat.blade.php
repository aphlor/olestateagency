<!-- chat here -->
<div class="panel panel-default"><div class="panel-body">
    @if ($subject == 'property')
    <!-- if we're viewing a property, include brief details -->
    <div class="panel panel-primary">
        <div class="panel-heading">You are discussing property</div>
        <div class="panel-body">
            @if (isset($property))
                @include('property.listing')
            @else
                Error fetching property data
            @endif
        </div>
    </div>
    @endif

    <!-- waiting -->
    <div class="panel panel-warning">
        <div class="panel-heading">System</div>
        <div class="panel-body">
            Waiting for a staff member to become available
        </div>
    </div>

    <div id="chat-area">
    </div>

    <div class="form-group" id="chat-entry">
        <div class="input-group">
            <input type="text" class="form-control" id="chat-message" placeholder="Type your message here and press &lt;return&gt; to send..." autofocus disabled />
            <span class="input-group-btn">
                <button id="msg-send" class="btn btn-success">Send</button>
            </span>
        </div>
    </div>
</div></div>
