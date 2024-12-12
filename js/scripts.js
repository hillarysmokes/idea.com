document.addEventListener("DOMContentLoaded", () => {
    const upvoteButtons = document.querySelectorAll(".upvote-btn");

    upvoteButtons.forEach(button => {
        button.addEventListener("click", () => {
            const ideaId = button.getAttribute("data-id");

            fetch("upvote_idea.php", {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: `id=${ideaId}`,
            })
            .then(response => response.text())
            .then(data => {
                if (data === "Success") {
                    alert("Idea upvoted!");
                    location.reload();
                } else {
                    alert("Error upvoting idea!");
                }
            });
        });
    });
});
