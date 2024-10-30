<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Key Calculation</title>
    <!-- Add Bootstrap or other CSS framework if needed -->
</head>
<body>
    <div class="container">
        <h2>Calculate Key</h2>
        <form id="calculate-key-form">
            @csrf
            <div class="form-group">
                <label for="ss_refer">SS-REFER:</label>
                <input type="text" id="ss_refer" name="ss_refer" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="ss_rang">SS-RANG:</label>
                <input type="number" id="ss_rang" name="ss_rang" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Calculate</button>
        </form>

        <div id="result" style="display:none; margin-top: 20px;">
            <h3>Calculation Result</h3>
            <p><strong>SS-CLESUCC-RANG:</strong> <span id="ss_clesucc_rang"></span></p>
            <p><strong>SS-CLESUCC-CLE:</strong> <span id="ss_clesucc_cle"></span></p>
        </div>
    </div>

    <!-- jQuery for AJAX request (or use Fetch API if preferred) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#calculate-key-form').on('submit', function (e) {
                e.preventDefault();

                // Gather form data
                const formData = {
                    _token: '{{ csrf_token() }}',
                    ss_refer: $('#ss_refer').val(),
                    ss_rang: $('#ss_rang').val(),
                };

                // AJAX request to calculate key
                $.post('/calculate-key', formData, function (response) {
                    alert(JSON.stringify(response));
                    $('#result').show();
                    $('#ss_clesucc_rang').text(response.ssClesuccRang);
                    $('#ss_clesucc_cle').text(response.ssClesuccCle);
                }).fail(function () {
                    alert("An error occurred. Please try again.");
                });
            });
        });
    </script>
</body>
</html>
