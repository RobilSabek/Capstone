document.getElementById('codeForm').addEventListener('submit', function(event) {
    event.preventDefault();
    const code = document.getElementById('codeInput').value;
    fetch('community.php', {
      method: 'POST',
      body: JSON.stringify({ code }),
      headers: {
        'Content-Type': 'application/json'
      }
    })
    .then(response => response.json())
    .then(data => {
      updateCodeHistory(); 
    })
    .catch(error => {
      console.error('Error:', error);
    });
  });

// Refactored submitCode function in community.js
function submitCode(code) {
    fetch('submit_code.php', {
        method: 'POST',
        body: JSON.stringify({ code }),
        headers: {
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            updateCodeHistory(); 
        } else {
            console.error('Error:', data.error);
            // Provide user feedback about submission failure
        }
    })
    .catch(error => {
        console.error('Error:', error);
        // Provide user feedback about network or unexpected errors
    });
}


function updateCodeHistory() {
    fetch('fetch_codes.php')
    .then(response => response.json())
    .then(data => {
        const codeHistoryDiv = document.getElementById('codeHistory');
        codeHistoryDiv.innerHTML = '';

        data.forEach(codeEntry => {
            const codeEntryDiv = document.createElement('div');
            codeEntryDiv.classList.add('codeEntry');
            codeEntryDiv.setAttribute('data-code-id', codeEntry.id);

            const codeContent = document.createElement('pre');
            codeContent.textContent = codeEntry.code;
            codeEntryDiv.appendChild(codeContent);

            
            const commentForm = document.createElement('form');
            commentForm.classList.add('commentForm');
            const commentInput = document.createElement('input');
            commentInput.setAttribute('type', 'text');
            commentInput.setAttribute('placeholder', 'Write a comment');
            const commentSubmit = document.createElement('button');
            commentSubmit.textContent = 'Submit Comment';
            commentSubmit.addEventListener('click', function(event) {
                event.preventDefault();
                const commentText = commentInput.value;
                submitComment(codeEntry.id, commentText);
            });
            commentForm.appendChild(commentInput);
            commentForm.appendChild(commentSubmit);
            codeEntryDiv.appendChild(commentForm);

            codeHistoryDiv.appendChild(codeEntryDiv);

            fetchComments(codeEntry.id)
                .then(comments => {
                    const codeEntryDiv = document.querySelector(`[data-code-id="${codeEntry.id}"]`);
                    appendCommentsToEntry(codeEntryDiv, comments);
                })
                .catch(error => {
                    console.error('Error fetching comments:', error);
                });
        });
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

function fetchComments(codeId) {
    return fetch('fetch_comments.php', {
        method: 'POST',
        body: JSON.stringify({ codeId }),
        headers: {
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json());
}

function submitComment(codeId, commentText) {
    fetch('submit_comment.php', {
        method: 'POST',
        body: JSON.stringify({ codeId, commentText }),
        headers: {
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        updateCodeHistory();
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

function appendCommentsToEntry(codeEntryDiv, comments) {
    comments.forEach(comment => {
        const commentDiv = document.createElement('div');
        commentDiv.classList.add('comment');
        commentDiv.textContent = comment.comment_text;
        codeEntryDiv.appendChild(commentDiv);
    });
}

updateCodeHistory();