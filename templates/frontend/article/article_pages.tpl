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
	alert(replyContent);
	$("div #editForm_" + replyId).show();
	$('#replyTextArea').val(replyContent);
	$("div #commentFormDiv").hide();
}





function myFunction() 
{
    confirm("Your comment will be permanently canceled !");
}



function incrementInput(id)
{
    document.getElementById(id).value++;
}

function incrementInput(id)
{
    document.getElementById(id).value++;
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
	<br><br>
	<!-- BEGIN comment_list -->

		<div class ="comment" id="{COMMENT_ID}">
			<p><a href="">{COMMENT_USERNAME}</a> : {COMMENT_CONTENT}</p>
			<div id = "divProfilePic" style="position: relative;left:-110px;"><a href = "{SITE_URL}/article/profile/id/{COMMENT_USERNAME}"><img src="{SITE_URL}/{PICTURE}" alt="NOT" class = "profilePic"></a></div>
			<!-- BEGIN reply_list -->
			<div class ="reply">
				<div id ='divReplyPicture'><a href = "{SITE_URL}/article/profile/id/{REPLY_USERNAME}"><img src="{SITE_URL}/{REPLY_PICTURE}" alt="NOT" class = "profilePic"></a></div>
				<p><a href="">#{REPLY_USERNAME}</a>: {REPLY_CONTENT} <button type="button" onclick = "editReply({REPLY_ID},'{REPLY_CONTENT}')">Edit {REPLY_ID}</button>
				<button type="button"><a href ="{SITE_URL}/article/delete_reply/id/{REPLY_ID}/questionId/{ID}">Delete {REPLY_ID}</a></button></p>
				
					<div id="editForm_{REPLY_ID}" style="display:none;" >
					<form action="{SITE_URL}/article/edit_reply/id/{COMMENT_ID}" method="POST">
					<input type="number" name="id" value="{ID}" hidden="true">	
					<textarea name="reply" placeholder="Enter reply here..." id="replyTextArea" class="replyTextArea"></textarea>
			  		<input type="submit" value="Edit reply" id = 'postReplyButton' class = 'fa fa-reply'>
					</form>
		</div>
			</div>
			<!-- END reply_list -->
		</div>
		<div class = "replyButton">
			<button id ="reply_{COMMENT_ID}" onclick = "showReply({COMMENT_ID})">Reply</button>
			<td width="25%"><a href="{SITE_URL}/article/delete_comment/id/{COMMENT_ID}/questionId/{ID}" title="Delete" class="delete_state"><button onclick="myFunction()">Delete</button></a></td>
		</div>
		<button name ='unlikeButton' type="button" id="{COMMENT_ID}" class = "downVoteBtn" value="{ID}" style = "float:right;margin: 5px 10px 0 0;"><span class="glyphicon glyphicon-thumbs-down"></span></button>
		<button name = 'likeButton' type="button" id="{COMMENT_ID}" class = "upVoteBtn" value="{ID}"  style = "float:right;margin: 5px 10px 0 0;"><span class="glyphicon glyphicon-thumbs-up"></span></button>
		<p id = "{COMMENT_ID}" class = "voteState"> 
			Like : <span class="likeCount" id="likeCount{COMMENT_ID}">{RATING}</span> 
		</p>
		<br><br><br><br>
		<div id="replyForm_{COMMENT_ID}" style="display:none;" >
			<form action="{SITE_URL}/article/post_reply/id/{COMMENT_ID}" method="POST">
				<input type="number" name="id" value="{ID}" hidden="true">	
				<textarea name="reply" placeholder="Enter reply here..." id="textarea" class="replyTextArea"></textarea>
			  	<input type="submit" value="Post Reply" id = 'postReplyButton' class = 'fa fa-reply'>
			</form>
		</div>

	<!-- END comment_list -->

	<br><br><br><br><br><br>
	<!-- BEGIN comment_form -->
	<div id="commentFormDiv">
	<form method="POST" action="{SITE_URL}/article/comment/id/{ID}">
	<textarea name = "comment"  placeholder="Enter comment here..." id = 'commentBox' class ="commentForm"></textarea><br/>
	<input type="submit" name="submit" value="Comment" class="commentButton" />
	</form><br>
	</div>
	<!-- END comment_form -->


	<a href ="{SITE_URL}/article/list" class = "">Back</a>
	<td width="25%"><a href="{SITE_URL}/article/delete_question/id/{ID}" title="Delete" class="delete_state"><button onclick="myFunction()">Delete</button></a></td>


</div>
<p class ="info">Published on:{DATE} by <a href="dasda">{COMMENT_USERNAME}</a></p>


<!--// 0729016066 //-->