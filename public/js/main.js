
$('#fuMain').fileinput({
	theme: 'fa',
            //allowedFileExtensions: ['png', 'jpg'],
            //uploadUrl: '/upload_article_poster',
            uploadAsync: false,
            showUpload: false,
            maxFileSize: 5120,
            removeClass: 'btn btn-warning'
        });
var simplemde = new SimpleMDE({
	element: document.getElementById("MyID")
});

function checkContent() {
	if (simplemde.value() != "") {
		document.getElementById("addquestion").submit();
	}
}

