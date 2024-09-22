<!DOCTYPE html>
<html>
<head>
    <title>Close Tab</title>
</head>
<body>
    <h1>This tab can be closed</h1>

    <button id="closeTabButton">Close Tab</button>

    <script>
        // Add a click event listener to the button
        document.getElementById('closeTabButton').addEventListener('click', function() {
            // Close the current tab or window
            window.close();
        });

        window.close();

    </script>
</body>
</html>
