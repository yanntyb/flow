<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<img src="" alt="" id="fake-image">
<form action="post" id="form">
    <input type="text" placeholder="fake-link" name="fake-link" id="link"/>
    <input type="file" id="fake-file"/>
    <button type="submit">
        Envoyer
    </button>
</form>
<script>
    const input = document.querySelector('#fake-file');
    const form = input.closest('form');
    const submit = form.querySelector('button');
    const link = form.querySelector('#link');
    const image = document.querySelector('#fake-image');

    submit.addEventListener('click', (e) => {
        e.preventDefault();
    })

    input.addEventListener('change', (e) => {
        storeFile(input.files[0]);
    })

    function storeFile(file)
    {
        const formData = new FormData();
        formData.append('file',file);
        const req = new XMLHttpRequest();
        req.open('POST', '{{ route("file.upload") }}');
        req.onload = function() {
            const data = JSON.parse(req.responseText);
            changeLinkValue(data.slug);
        }
        req.send(formData);
    }


    function changeLinkValue(slug)
    {
        const req = new XMLHttpRequest();
        req.open('GET', '{{ route('file.show') }}/' + slug);
        req.onload = function(){
            const data = JSON.parse(req.responseText);
            link.value = data.path;

        }
        req.send();
    }

</script>
</body>
</html>
