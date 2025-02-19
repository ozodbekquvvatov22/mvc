<!DOCTYPE html>
<html>

<head>
    <title>Posts</title>
</head>

<body>
    <h1>Post List</h1>
    <a href="/post/create">Create New Post</a>
    <ul>
        <?php 
        foreach ($posts as $post): ?>
            <li>
                <a href="/post/show?id=<?= $post['id'] ?>"><?= $post['title'] ?></a>
                <a href="/post/edit?id=<?= $post['id'] ?>">Edit</a>
                <a href="/post/delete?id=<?= $post['id'] ?>">Delete</a>
            </li>
        <?php endforeach; ?>
    </ul>
    <form action="/auth/logout" method="post">
    <button type="submit">Logout</button>
</form>
</body>

</html>