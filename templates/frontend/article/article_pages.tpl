<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script>
//var voteRequestUrl = '{SITE_URL}/article/voted/id/{COMMENT_ID}';
// function to get commend id and show reply form
function showReply(commentId)
{
	$("div #replyForm_"+commentId).show();
	$('#textarea').val('');
	$("div #commentFormDiv").hide();
}





function voteRequest(action,buttonId,questionId)
{

	//alert(action);
	//alert("Action : " + action + " buttonId : " + buttonId + " questionId :" + questionId);
	var voteRequestSettings = {
		'data' : {
			'action' : action,
			'commentId' : buttonId,
			'questionId' : questionId
		}, 
		'method' : 'POST'
	};


	if(action =='up' || action == 'down' )
	{
		var voteRequestUrl = '{SITE_URL}/article/vote/id/' + buttonId;

		$.ajax(voteRequestUrl,voteRequestSettings).done(function(response) {
			var receivedData = jQuery.parseJSON(response);

			// verifica daca requestul a fost succes == true ; !!!!!!!!!!
			
			//$("#likeCount"+buttonId).text(parseInt($("#likeCount"+buttonId).text()) + 1);
			// alert(receivedData.success);
		});
	}
	else
	{
		alert("!");
	}
}


$(document).ready(function()
{
   	    $(".upVoteBtn").click(function()
   	    {
      	 	//var me = $(this);
      	 	//alert("up");
      	 	voteRequest('up',this.id,$(this).attr('value'));
      	 	//alert(me.;
      	 	//alert(this.attr(value));
      	 	//alert($(this).attr('value'));
      	 	//var value = document.getElementById(this.id).value;
      	 	// alert(value);

  	    });

        $(".downVoteBtn").click(function()
        {
        	voteRequest('down',this.id,$(this).attr('value'));
    });
});




</script>

<style type="text/css">
	
.mainDiv
{
	box-shadow: 1px 1px 5px #888888;
	width: 125%;
	padding-left: 10px;
	background: rgba(255,255,255,1);
	background: -moz-linear-gradient(top, rgba(255,255,255,1) 0%, rgba(255,255,255,1) 6%, rgba(255,255,255,1) 14%, rgba(209,209,209,1) 49%, rgba(255,255,255,1) 84%, rgba(255,255,255,1) 100%);
	background: -webkit-gradient(left top, left bottom, color-stop(0%, rgba(255,255,255,1)), color-stop(6%, rgba(255,255,255,1)), color-stop(14%, rgba(255,255,255,1)), color-stop(49%, rgba(209,209,209,1)), color-stop(84%, rgba(255,255,255,1)), color-stop(100%, rgba(255,255,255,1)));
	background: -webkit-linear-gradient(top, rgba(255,255,255,1) 0%, rgba(255,255,255,1) 6%, rgba(255,255,255,1) 14%, rgba(209,209,209,1) 49%, rgba(255,255,255,1) 84%, rgba(255,255,255,1) 100%);
	background: -o-linear-gradient(top, rgba(255,255,255,1) 0%, rgba(255,255,255,1) 6%, rgba(255,255,255,1) 14%, rgba(209,209,209,1) 49%, rgba(255,255,255,1) 84%, rgba(255,255,255,1) 100%);
	background: -ms-linear-gradient(top, rgba(255,255,255,1) 0%, rgba(255,255,255,1) 6%, rgba(255,255,255,1) 14%, rgba(209,209,209,1) 49%, rgba(255,255,255,1) 84%, rgba(255,255,255,1) 100%);
	background: linear-gradient(to bottom, rgba(255,255,255,1) 0%, rgba(255,255,255,1) 6%, rgba(255,255,255,1) 14%, rgba(209,209,209,1) 49%, rgba(255,255,255,1) 84%, rgba(255,255,255,1) 100%);
	filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#ffffff', endColorstr='#ffffff', GradientType=0 );
}

.comment
{
	box-shadow: 1px 1px 5px #888888;
	width: 90%;
	padding-left: 10px;
	margin-left: 40px !important;

}
.reply
{
	margin-left: 60px !important;	
}

.replyButton
{
	float:right;
	margin: 5px 4.5% 0 0;
}
.info
{
	font-style: italic;
	float:right;
	font-size: 90%;
}

.replyTextArea
{
	resize: none;
	position: relative;
	max-width: 80%;
	height: 100px;
	width: 80%;
	left: 5%;
}

.commentForm
{
	resize: none;
	position: relative;
	max-width: 80%;
	height: 100px;
	width: 80%;
	left: 5%;

}

.commentButton
{
	float:right;
	margin: -30px 4.5% 0 0;
	top:10px;
}

.likeButton
{
	float:right;
	margin: 5px 35px 0 0;
	top:10px;
}

.unlikeButton
{
	float:right;
	margin: 5px 35px 0 0;
	top:10px;
}

.voteState
{	
	font-style: italic;
	font-size: 80%;
	float:left;
	margin: 0 0 0 45px;
	top:10px;
}
</style>

<div class="mainDiv">
	<h2>{TITLE}</h2>
	<p>{CONTENT}</p>
	<!-- BEGIN comment_list -->
		<div class ="comment" id="{COMMENT_ID}">
			<p><a href="">{COMMENT_USERNAME}</a> : {COMMENT_CONTENT}</p>
				<p> Question ID : {ID} </p>
				<p> COMMENT_ID  :  {COMMENT_ID}</p>
			<!-- BEGIN reply_list -->
			<div class ="reply">
				<p><a href="">#{REPLY_USERNAME}</a>: {REPLY_CONTENT} </p>
			</div>
			<!-- END reply_list -->
		</div>
		<div class = "replyButton">
			<button id ="reply_{COMMENT_ID}" onclick = "showReply({COMMENT_ID})">Reply</button>
		</div>

		<button type="button" id="{COMMENT_ID}" class = "downVoteBtn" value="{ID}" style = "float:right;margin: 5px 10px 0 0;">Down</button>
		<button type="button" id="{COMMENT_ID}" class = "upVoteBtn" value="{ID}" style = "float:right;margin: 5px 10px 0 0;">Up</button>
		<p id = "{COMMENT_ID}" class = "voteState"> 
			Like : <span class="likeCount" id="likeCount{COMMENT_ID}">{LIKE}</span> 
			Dislike : <span class="disLikeCount" id="disLikeCount{COMMENT_ID}">{DISLIKE}</span>
		</p>
		<br><br><br><br>
		<div id="replyForm_{COMMENT_ID}" style="display:none;" >
			<form action="{SITE_URL}/article/post_reply/id/{COMMENT_ID}" method="POST">
				<input type="number" name="id" value="{ID}" hidden="true">	
				<textarea name="reply" placeholder="Enter reply here..." id="textarea" class="replyTextArea"></textarea>
			  	<input type="submit" value="Post Reply" style="position: relative; right:-40px;top : -10px;">
			</form>
		</div>

	<!-- END comment_list -->

	<br><br><br><br><br><br>
	<!-- BEGIN comment_form -->
	<div id="commentFormDiv">
	<form method="POST" action="{SITE_URL}/article/comment/id/{ID}">
	<textarea name = "comment"  placeholder="Enter comment here..." style="max-width: 95%; height: 100px;" class ="commentForm"></textarea><br/>
	<input type="submit" name="submit" value="Comment" class="commentButton" />
	</form><br>
	</div>
	<!-- END comment_form -->

	<a href ="{SITE_URL}/article/list" class = "">Back</a>


</div>
<p class ="info">Published on:{DATE} by <a href="dasda">{ID}</a></p>
