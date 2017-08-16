</br>
Comentarii : 
<!-- BEGIN comment_list -->
<div class ="comment">
<p>{COMMENT_USERNAME} : {COMMENT_CONTENT}<a href ="{SITE_URL}/article/reply"> Reply</a></p>
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