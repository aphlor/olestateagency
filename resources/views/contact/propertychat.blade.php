<!-- chat here -->
<div class="panel panel-default"><div class="panel-body">
    @if ($subject == 'property')
    <!-- if we're viewing a property, include brief details -->
    <div class="panel panel-primary">
        <div class="panel-heading">You are discussing property</div>
        <div class="panel-body">
            @if (isset($property))
                @include('property.listing')
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
            Hello, I'm interested in this property. My budget is slightly
            lower than the expected value. Would I be able to arrange a
            viewing if the vendor would consider an offer around &pound;440,000?
        </div>
    </div>

    <!-- message from -->
    <div class="panel panel-success">
        <div class="panel-heading">Joe Bloggs</div>
        <div class="panel-body">
            I'm sure the we can discuss the possibility of entertaining offers below
            the list price with the vendor. May I enquire as to your availability for
            viewings?
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
