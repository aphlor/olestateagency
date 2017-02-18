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

    <!-- message from -->
    <div class="panel panel-success">
        <div class="panel-heading">Joe Bloggs</div>
        <div class="panel-body">
            Hi, how are you today? My name is Joe, how can I help?
        </div>
    </div>

    <!-- message to -->
    <div class="panel panel-info">
        <div class="panel-heading">You</div>
        <div class="panel-body">
            Hello, I'm looking for studio apartments in the area but see none listed;
            do you see many appearing for sale? If not, are there any small apartments
            that fit a low budget?
        </div>
    </div>

    <!-- message from -->
    <div class="panel panel-success">
        <div class="panel-heading">Joe Bloggs</div>
        <div class="panel-body">
            I see. I'm sorry, but we don't see many studio properties, however we have
            two one-bedroom flats listed on a newly built estate in the east of the
            town within a short distance of the town centre and train station. Would
            something like this suit your requirements?
        </div>
    </div>

    <div class="form-group">
        <div class="input-group">
            <input type="text" class="form-control" id="chat-message" placeholder="Type your message here and press &lt;return&gt; to send..." autofocus />
            <span class="input-group-btn">
                <button class="btn btn-success">Send</button>
            </span>
        </div>
    </div>
</div></div>
