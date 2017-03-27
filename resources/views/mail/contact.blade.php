<!DOCTYPE html>
<html lang="en">
    <body>
        <p>You have received a communication from the website.</p>

        <table style="border: 1px solid grey">
            <tbody>
                <tr>
                    <td><strong>Sender</strong></td>
                    <td>{{ $senderName }} &lt;<a href="mailto:{{ $senderEmail }}">{{ $senderEmail }}</a>&gt;</td>
                </tr>
                <tr>
                    <td colspan="2"><strong>Message</strong></td>
                </tr>
                <tr>
                    <td colspan="2"><pre>{{ $body }}</pre></td>
                </tr>
            </tbody>
        </table>
    </body>
</html>
