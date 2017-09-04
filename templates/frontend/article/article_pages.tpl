<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="{SITE_URL}/externals/bootstrap/css/stylesheet.css">
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-T8Gy5hrqNKT+hzMclPo118YTQO6cYprQmhrYwIiQ/3axmI1hQomh7Ud2hPOy8SP1" crossorigin="anonymous">
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

function editReply(replyId,replyContent)
{	
	//alert(replyContent);
	$("div #editForm_" + replyId).show();
	$('#commentTextArea').val(replyContent);
	$("div #commentFormDiv").hide();
}


function editComment(commentId,commentContent)
{	
	//alert(commentContent);
	//alert(commentId);
	$("div #editCommentForm_" + commentId).show();
	$('#commentTextArea').val(commentContent);
	$("div #commentFormDiv").hide();
}


function myFunction() 
{
    confirm("Your comment will be permanently canceled !");
}


function voteRequest(action,buttonId,questionId,buttonClass)
{
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
			//alert(receivedData);
			var stringReceivedData = JSON.stringify(receivedData);

			if(stringReceivedData.search('succes') > 0)
			{	//likeCount{COMMENT_ID}
				var ratingButton = "likeCount" + buttonId;

				//alert(ratingButton);
				// server respon se true , increment likes + 1 ; 
				//alert(buttonId);
				var rating = document.getElementById(ratingButton);
   			 	var ratingNumber = rating.innerHTML;
    				ratingNumber++;
    				rating.innerHTML = ratingNumber;


    				if (buttonClass == 'upVoteBtn')
					{	
						ratingNumber++;
					}
					else if (buttonClass == 'downVoteBtn')
					{
						ratingNumber--;
					}

				//$(buttonId).attr('disabled','disabled');
				// if (action == 'up')
				// {
				// 	$(buttonId).attr('disabled','disabled');
				// }
				// else
				// 	if (action = 'down')
				// 	{
				// 		$(buttonId).attr('disabled','disabled');
				// 	}
			}
			else
			{
				//alert("NO");
				// server response false 
			}
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
   	    	var buttonClass = $(this).attr("class");
      	 	voteRequest('up',this.id,$(this).attr('value'),buttonClass);
      	 	$(this).attr('disabled','disabled');
      	 	$('.downVoteBtn').attr('disabled','disabled');
  	    });

        $(".downVoteBtn").click(function()
        {
        	var buttonClass = $(this).attr("class");
      	 	voteRequest('down',this.id,$(this).attr('value'),buttonClass);
      	 	$(this).attr('disabled','disabled');
      	 	$('.upVoteBtn').attr('disabled','disabled');

      		//increment(this.id);
      	});
});

</script>


<div class="mainDiv">
	<h2>{TITLE}</h2>
	<p>{CONTENT}</p>
	<!-- <p>{USERNAME}</p>
 -->
	<!-- BEGIN comment_form -->

		<div id="commentFormDiv">
			<form method="POST" action="{SITE_URL}/article/comment/id/{ID}">
			<textarea name = "comment"  placeholder="Enter comment here..." id = 'commentBox' class ="commentForm"></textarea><br/>
			<input type="submit" name="submit" value="Comment" class="commentButton" />
			</form><br>
		</div>
		<br><br>
	<!-- END comment_form -->

	<!-- BEGIN comment_list -->

	<div class="comments-container">
		<ul id="comments-list" class="comments-list">
			<li>
				<div class="comment-main-level">
					<!-- Avatar -->
					<div class="comment-avatar"><img src="{SITE_URL}/{REPLY_IMAGE}" alt="NOT" class = "profilePic"></div>
					<!-- Contenedor del Comentario -->
					<div class="comment-box">
						<div class="comment-head">
							<h6 class="comment-name by-author"><a href="{SITE_URL}/article/profile/id/{COMMENT_USERNAME}">{COMMENT_USERNAME}</a></h6>
							<i id ="comment_{COMMENT_ID}" onclick = "showReply({COMMENT_ID})" class="fa fa-reply"></i>
							<a href="{SITE_URL}/article/delete_comment/id/{COMMENT_ID}/questionId/{ID}" title="Delete" class="delete_state"><i class="fa fa-trash" onclick ="myFunction()"></i></a>								
							<i onclick="editComment({COMMENT_ID},'{COMMENT_CONTENT}')" class="fa fa-pencil"></i>

							<div id="editCommentForm_{COMMENT_ID}" style="display:none;" >
								<form action="{SITE_URL}/article/edit_comment/id/{COMMENT_ID}" method="POST">
									<input type="number" name="id" value="{ID}" hidden="true">
									<input type="number" name="commentId" value="{COMMENT_ID}" hidden="true">
									<input type="text" name="commentUserName" value="{COMMENT_USERNAME}" hidden="true">	
									<textarea name="comment" placeholder="Edit comment..." id="replyTextArea" class="replyTextArea"></textarea>
			  						<input type="submit" value="Save" id = 'postReplyButton3' class = 'fa fa-reply'>
								</form>
							</div>
						</div>
							<div class="comment-content">
								{COMMENT_CONTENT}
								<div id="replyForm_{COMMENT_ID}" style="display:none;" >
									<form action="{SITE_URL}/article/post_reply/id/{COMMENT_ID}" method="POST">
										<input type="number" name="id" value="{ID}" hidden="true">	
										<textarea name="reply" placeholder="Enter reply here..." id="textarea" class="replyTextArea"></textarea>
							  			<input type="submit" value="Post Reply" id = 'postReplyButton' class = 'fa fa-reply'>
									</form>
								</div>
							</div>
					</div>
				</div>
					<p id = "{COMMENT_ID}" class = "voteState"> Like : <span class="likeCount" id="likeCount{COMMENT_ID}">{RATING}</span> </p>
				<button name ='unlikeButton' type="button" id="{COMMENT_ID}" class = "downVoteBtn" value="{ID}" style = "float:right;margin: 5px 10px 0 0;"><span class="glyphicon glyphicon-thumbs-down"></span></button>
				<button name = 'likeButton' type="button" id="{COMMENT_ID}" class = "upVoteBtn" value="{ID}"  style = "float:right;margin: 5px 10px 0 0;"><span class="glyphicon glyphicon-thumbs-up"></span></button>

			<!-- BEGIN reply_list -->
			<div class ="reply">
				<ul class="comments-list reply-list">
					<li>
						
						<div class="comment-avatar"><div id ='divReplyPicture'><a href = "{SITE_URL}/article/profile/id/{REPLY_USERNAME}"><img src="{SITE_URL}/{REPLY_IMAGE}" alt="NOT" class = "profilePic"></a></div></div>
						
						<div class="comment-box">
							<div class="comment-head">
								<h6 class="comment-name"><a href="http://creaticode.com/blog">#{REPLY_USERNAME}</a></h6>
								<a href ="{SITE_URL}/article/delete_reply/id/{REPLY_ID}/questionId/{ID}" ><i class="fa fa-trash" onclick ="myFunction()"></i></a>
								<i onclick = "editReply({REPLY_ID},'{REPLY_CONTENT}')" class="fa fa-pencil"></i>
								<div id="editForm_{REPLY_ID}" style="display:none;" >
						<form action="{SITE_URL}/article/edit_reply/id/{COMMENT_ID}" method="POST">
							<input type="number" name="id" value="{ID}" hidden="true">
							<input type="number" name="replyId" value="{REPLY_ID}" hidden="true">
							<input type="text" name="replyUserName" value="{REPLY_USERNAME}" hidden="true">	
							<textarea name="reply" placeholder="Enter reply here..." id="replyTextArea" class="replyTextArea"></textarea>
			  				<input type="submit" value="Edit reply" id = 'postReplyButton2' class = 'fa fa-reply'>
						</form>
					</div>
								
								<!-- <i id ="reply_{COMMENT_ID}" onclick = "showReply({COMMENT_ID})" class="fa fa-reply"></i> -->

							</div>
							<div class="comment-content">
							{REPLY_CONTENT} 
							</div>
						</div>
					</li>
				<!-- <button id="buttonReply" type="button" onclick = "editReply({REPLY_ID},'{REPLY_CONTENT}')">Edit {REPLY_ID}</button> -->
				<!-- <button id="buttonDelete" type="button"><a href ="{SITE_URL}/article/delete_reply/id/{REPLY_ID}/questionId/{ID}">Delete {REPLY_ID}</a></button> --></p>

				</ul>	
				
					
			</div>
			<!-- END reply_list -->

					
		</div>

	<!-- END comment_list -->

	<br><br><br><br><br><br>



	<a href ="{SITE_URL}/article/list" class = "">Back</a>
	<td width="25%"><a href="{SITE_URL}/article/delete_question/id/{ID}" title="Delete" class="delete_state"><button onclick="myFunction()">Delete</button></a></td>


</div>
<p class ="info">Published on:{DATE} by <a href="dasda">{USERNAME}</a></p>

<!--// 0729016066 //-->