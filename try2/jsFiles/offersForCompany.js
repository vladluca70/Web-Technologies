document.getElementById('getHelloButton').addEventListener('click', function() 
{
    fetch('http://localhost/try/phpFiles/get_hello.php')
        .then(response => {
            if (!response.ok) 
            {
                throw new Error('Network response was not ok');
            }
            return response.text();
        })
        .then(data => {
            document.getElementById('result').innerHTML = data;
        })
        .catch(error => {
            document.getElementById('result').textContent = 'Fetch Error: ' + error.message;
        });
});