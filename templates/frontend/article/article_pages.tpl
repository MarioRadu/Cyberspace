<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script>

// function to get commend id and show reply form
function showReply(commentId)
{
	$("div #replyForm_"+commentId).show();
	$('#textarea').val('');
}

</script>


<h1>{TITLE}</h1>
<p class="comment"> Intrebare : {CONTENT}</p>
<p>Date : {DATE}</p>
</br>
Comentarii : 
<!-- BEGIN comment_list -->
<div class ="comment">
<p>{COMMENT_USERNAME} : {COMMENT_CONTENT} <button id ="reply_{COMMENT_ID}" onclick = "showReply({COMMENT_ID})">Reply</button></p>
</div>

<div id="replyForm_{COMMENT_ID}" style="display:none;">
	<form action="{SITE_URL}/article/post_reply/id/{COMMENT_ID}" method="POST">
	<textarea name="reply" placeholder="Enter text here..." id="textarea">		
	</textarea>
  	<input type="submit" value="Post Reply">
	</form>
</div>

<!-- BEGIN reply_list -->
<div class ="reply" style="margin-left: 40px !important;">
<p>{REPLY_USERID} : {REPLY_CONTENT} </p>


</div>
<!-- END reply_list -->


<!-- END comment_list -->

<!-- BEGIN comment_form -->
<form method="POST" action="{SITE_URL}/article/comment/id/{ID}">
<textarea name = "comment" cols = "110" rows = "2" placeholder="Comment here"></textarea><br/>

<input type="submit" name="submit" value="submit" />
</form><br>
<!-- END comment_form -->

<a href ="{SITE_URL}/article/list" class = "">Back</a>