
$('#qr').on('input', function() {
    var inputText = $(this).val();
    console.log(inputText);
    $('#results').empty();
    $.ajax({
        url: '/ajax?query=' + inputText,
        method: 'GET', 
        dataType: 'json',
        success: function(response) {
            
            response.forEach(element => {
                var htmlValue = element.html;
                $('#results').append(htmlValue);
            });
            //console.log(htmlValue);
            // Add the html value to the last place in the div with class "content"
        },
        error: function(xhr, status, error) {
            // Handle error
            console.log(error);
        }
    });
});

