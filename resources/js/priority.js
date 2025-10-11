document.addEventListener("DOMContentLoaded", function () {
    const prioritySelects = document.querySelectorAll(".priority-select");

    prioritySelects.forEach(prioritySelect => {
        prioritySelect.addEventListener("change", function(){
            let selectedValue = this.value;
            let questionId = this.dataset.question_id;

            console.log("送信データ:", { question_id: questionId, priority_num: selectedValue });

            fetch("/priority", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
                },
                body: JSON.stringify({ 
                    question_id: questionId,
                    priority_num: selectedValue }),
            })
            .then(response => response.json())
            .then(data => {
                console.log("更新成功:", data);
                // window.location.reload();
            })
            .catch(error => {
                console.error("更新失敗:", error);
            });
        });
    });
});
