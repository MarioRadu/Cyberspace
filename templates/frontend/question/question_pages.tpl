<h1>{TITLE}</h1>
<p>{CONTENT}</p>
<p>{DATE}</p>

<!-- GO BACK BUTTON -->
<a href ="{SITE_URL}/question/list" class = "">Back</a>

<!-- COMMENT BOX -->

<!-- BEGIN comment -->
<form method="POST" action="{SITE_URL}/question/comment/id/{ID}">
<textarea name = "comment" cols = "110" rows = "2">Comment here</textarea><br/>

<input type="submit" name="submit" value="submit" />
</form>

<!-- END comment -->

