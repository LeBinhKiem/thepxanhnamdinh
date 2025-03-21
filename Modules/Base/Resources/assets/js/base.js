var UpLoad = {
    init() {
        let url = $(".js-show-file").data("link");
        if (url !== "" && url !== undefined) {
            $(".js-form-upload").addClass("active");
            $(".js-show-file").find(".name").html(getFileNameFromPath(url))
            $(".js-show-option").addClass("hide")

            function getFileNameFromPath(path) {
                let pathArray = path.split('/');
                let fileName = pathArray[pathArray.length - 1];
                return fileName;
            }

            // fetch(url)
            //     .then(response => {
            //         if (!response.ok) {
            //             throw new Error(`Network response was not ok: ${response.status}`);
            //         }
            //         return response;
            //     })
            //     .then(response => response.blob())
            //     .then(blob => {
            //         const fileType = blob.type;
            //         const fileSize = blob.size;
            //         $(".js-show-file").find(".size").text(fileSize)
            //         $(".js-show-file").find(".type").text(fileType)
            //     })
            //     .catch(error => {
            //         console.error('Error fetching file details:', error.message);
            //     });
        }

        $(".js-choose-file input").change(function (e) {
            console.log();
            let file = e.target.files[0];
            let form = $(this).closest(".js-form-upload")

            form.addClass("active");
            form.find(".name").text(limitCharacters(file.name, 30))
            form.find(".size").text(file.size)
            form.find(".type").text(file.type)

            function limitCharacters(text, limit) {
                if (text.length > limit) {
                    return text.substring(0, limit) + '...';
                } else {
                    return text;
                }
            }
        })

        $(".js-remove-file").click(function (e) {
            e.stopPropagation()
            let confirmDelete = confirm('Bạn chắc chắn muốn xóa?');
            if (!confirmDelete)
                return;

            $(".js-form-upload").removeClass("active");
            $(".js-choose-file input").val("");
            $(".js-show-option").removeClass("hide")
        })

        $(".js-show-file").click(function (e) {
            let url = $(this).data("link");
            if (url === "" || url === undefined) {
                return;
            }

            window.open(url, '_blank');
        })
    }
}

$(function () {
    UpLoad.init()
})