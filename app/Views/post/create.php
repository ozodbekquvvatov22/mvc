<!DOCTYPE html>
<html>

<head>
    <title>Create Task</title>
</head>

<body>
    <h1>Create Task</h1>
    <form action="/post/store" method="post">
        <input type="text" name="title" placeholder="Title" required><br>
        <textarea name="content" placeholder="content"></textarea><br>
        <button type="submit">Save Task<?php ?></button>
        

    </form>
    
</body>

</html>