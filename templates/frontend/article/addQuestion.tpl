<link rel="stylesheet" type="text/css" href="{SITE_URL}/externals/bootstrap/css/stylesheet.css">
<link rel="stylesheet" href="{TEMPLATES_URL}/css/frontend/style.css" type="text/css">
<form action="{SITE_URL}/article/post_question" class="form-style-9" method="POST" id="form">
<ul>
<li>
  Title: <input type="text" class="field-style field-full align-none" name="title" placeholder="Question Title">
</li>
<li>
  Question content: <textarea name="question" form="form" class="field-style" placeholder="Question"></textarea>
</li>
<li>
  <input type="submit">
</li>
</ul>
<a href ="{SITE_URL}/article/list" class = "">Back</a>
</form>