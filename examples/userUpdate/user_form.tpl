<h2>Update User</h2>
<form method="post" action="update_user.php">
    <input type="hidden" name="id" value="{{ $user['id'] }}">
    <label>Name:</label>
    <input type="text" name="name" value="{{ $user['name'] }}"><br>
    <label>Email:</label>
    <input type="email" name="email" value="{{ $user['email'] }}"><br>
    <button type="submit">Update</button>
</form>
