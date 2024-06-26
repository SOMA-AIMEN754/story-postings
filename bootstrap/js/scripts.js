document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.comment-toggle').forEach(button => {
        button.addEventListener('click', function () {
            const postId = this.dataset.postId;
            const commentSection = document.getElementById(`comments-${postId}`);
            if (commentSection) {
                commentSection.style.display = commentSection.style.display === 'none' ? 'block' : 'none';
            } else {
                console.error(`Comment section for post ID ${postId} not found.`);
            }
        });
    });

    document.querySelectorAll('.reply-button').forEach(button => {
        button.addEventListener('click', function () {
            const commentId = this.dataset.commentId;
            console.log(`Comment ID: ${commentId}`); // Debug statement
            const replySection = document.getElementById(`replies-${commentId}`);
            if (replySection) {
                replySection.style.display = replySection.style.display === 'none' ? 'block' : 'none';
                if (!replySection.querySelector('.reply-form')) {
                    const replyForm = document.createElement('form');
                    replyForm.classList.add('reply-form');
                    replyForm.innerHTML = `
                        <textarea placeholder="Write a reply..." required></textarea>
                        <button type="submit">Reply</button>
                    `;
                    replySection.appendChild(replyForm);

                    replyForm.addEventListener('submit', function (event) {
                        event.preventDefault();
                        const content = this.querySelector('textarea').value;
                        const xhr = new XMLHttpRequest();
                        xhr.open('POST', 'reply_ajax.php', true);
                        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                        xhr.onload = function () {
                            if (xhr.status === 200) {
                                const response = JSON.parse(xhr.responseText);
                                if (response.success) {
                                    const newReply = document.createElement('div');
                                    newReply.innerHTML = `<strong>${response.username}</strong>: ${response.content}`;
                                    replySection.appendChild(newReply);
                                    replyForm.querySelector('textarea').value = '';

                                    // Update reply count
                                    const replyCountElement = document.querySelector(`.reply-count[data-comment-id='${commentId}']`);
                                    const replyCount = parseInt(replyCountElement.innerText.match(/\d+/)[0]);
                                    replyCountElement.innerText = `(${replyCount + 1} replies)`;
                                } else {
                                    alert('Error: ' + response.error);
                                }
                            }
                        };
                        xhr.send('comment_id=' + commentId + '&content=' + encodeURIComponent(content));
                    });
                }
            } else {
                console.error(`Reply section for comment ID ${commentId} not found.`);
            }
        });
    });

    document.querySelectorAll('.share-button').forEach(button => {
        button.addEventListener('click', function () {
            const postId = this.dataset.postId;
            const shareSection = document.getElementById(`share-form-${postId}`);
            if (shareSection) {
                shareSection.style.display = shareSection.style.display === 'none' ? 'block' : 'none';
            } else {
                console.error(`Share form for post ID ${postId} not found.`);
            }
        });
    });

    document.querySelectorAll('.like-button').forEach(button => {
        button.addEventListener('click', function () {
            const postId = this.dataset.postId;
            const likeForm = document.getElementById(`like-form-${postId}`);
            if (likeForm) {
                likeForm.submit();
            } else {
                console.error(`Like form for post ID ${postId} not found.`);
            }
        });
    });

    document.querySelectorAll('.comment-count').forEach(button => {
        button.addEventListener('click', function () {
            const postId = this.dataset.postId;
            const commentForm = document.getElementById(`comment-form-${postId}`);
            if (commentForm) {
                commentForm.style.display = commentForm.style.display === 'none' ? 'block' : 'none';
            } else {
                console.error(`Comment form for post ID ${postId} not found.`);
            }
        });
    });

    document.querySelectorAll('.reply-count').forEach(button => {
        button.addEventListener('click', function () {
            const commentId = this.dataset.commentId;
            const replySection = document.getElementById(`replies-${commentId}`);
            if (replySection) {
                replySection.style.display = replySection.style.display === 'none' ? 'block' : 'none';
            } else {
                console.error(`Reply section for comment ID ${commentId} not found.`);
            }
        });
    });
});
