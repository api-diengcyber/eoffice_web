<style>
    .sidebar {
        display: none;
    }

    .main-panel {
        width: 100% !important;
    }

    body {
        background: whitesmoke;
    }

    .content-wrapper {
        background: whitesmoke !important;
    }

    .card {
        border: solid 1px #dcdcdc;
    }

    .task {
        z-index: 999999;
    }

    .task>li {
        border-radius: 5px !important;
    }

    .task>li:hover {
        border-color: #00ce68 !important;
    }

    .sortable {
        min-height: 150px;
    }
</style>
<div class="row">
    <div class="col-md-12 mb-2">
              <a href="<?=base_url()?>" class="btn btn-default">Home</a>
    </div>
    <div class="col-md-3">
        <div class="card border pb-0">
            <div class="card-header bg-warning text-white">
                TODO LIST
            </div>
            <div class="p-2">
                <ul class="sortable pl-0 task" id="1">
                </ul>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border pb-0">
            <div class="card-header bg-primary text-white">
                ON PROGRESS
            </div>
            <div class="p-2">
                <ul class="sortable pl-0 task" id="2">
                </ul>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border pb-0">
            <div class="card-header bg-success text-white">
                FINISH
            </div>
            <div class="p-2">
                <ul class="sortable pl-0 task" id="3">
                </ul>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border pb-0">
            <div class="card-header bg-success text-white">
                ARSIP
            </div>
            <div class="p-2">
                <ul class="sortable pl-0 task" id="4">
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="modalDetail" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Task Detail</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p id="description"></p>
                <ul class="pl-0 detailBody" style="max-height:60vh;overflow-y:auto;">

                </ul>
            </div>
            <div class="modal-footer">
                <input type="text" class="form-control" id="messageInput">
                <button type="button" class="btn btn-primary no-radius sendMessage">Kirim</button>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js" integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=" crossorigin="anonymous"></script>
<script>
    var idTask;
    /**
        Components
     */
    var taskCard = function(params) {
        return `
            <li class="card p-2 mb-1 task-item" data-id="${params.id}" data-description="${params.description}">
                <div class="d-flex justify-content-between text-small font-weight-bold">
                    <label>${params.project}</label>
                    <label>Date Created : ${params.date_created}</label>
                </div>
                <p>${params.task}</p>
                <label>${params.name} : <label class="badge badge-info">${params.status}</label></label>
            </li>
        `;
    }
    var taskCardContent = function(params) {
        return `
            <div class="d-flex justify-content-between text-small font-weight-bold">
                <label>${params.project}</label>
                <label>Date Created : ${params.date_created}</label>
            </div>
            <p>${params.task}</p>
            <label>${params.name} : <label class="badge badge-info">${params.status}</label></label>
        `;
    }
    var taskDetail = function(params) {
        return `
            <li class="card p-2 mb-1">
                <div class="d-flex justify-content-between">
                    <label>${params.name}</label>
                    <label>${params.date_created}</label>
                </div>
                <p>${params.message}</p>
            </li>
        `;
    }
    /**
        Function
     */
    function getData() {
        return new Promise((resolve, reject) => {
            $.ajax({
                type: "POST",
                url: "<?php echo base_url("api/project-board/get-data"); ?>",
                success: function(response) {
                    console.log(response);
                    updateList(response);
                    resolve();
                }
            });
        })
    }

    function getDetail(id) {
        $.ajax({
            type: "POST",
            url: "<?php echo base_url("api/project-board/get-detail"); ?>",
            data: {
                id: id
            },
            success: function(response) {
                updateDetail(response.reverse());
            }
        });
    }

    function updateDetail(data) {
        var detail = "";
        for (let i in data) {
            let item = data[i];
            detail += taskDetail(item);
        }
        $(".detailBody").html(detail);
    }

    function updateList(data) {
        console.log(data);
        var todo = "",
            progress = "",
            finish = "",
            arsip = "";
        for (let i in data) {
            let item = data[i];
            switch (item.id_status) {
                case "1":
                    // console.log("disini")
                    todo += taskCard(item);
                    break;
                case "2":
                    progress += taskCard(item);
                    break;
                case "3":
                    finish += taskCard(item);
                    break;
                case "4":
                    arsip += taskCard(item);
                    break;
                default:
                    break;
            }
        }
        $('.sortable#1').html(todo);
        $('.sortable#2').html(progress);
        $('.sortable#3').html(finish);
        $('.sortable#4').html(arsip);
    }
    /**
        Dom Manipulation
     */
    $(document).ready(function() {

        getData().then(function(res) {
            // alert("load done");
        });
        $(".sortable").sortable({
            connectWith: "ul",
            receive: function(event, ui) {
                let idStatus = this.id;
                let idTask = ui.item.attr("data-id");
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url("api/project-board/update-task"); ?>",
                    data: {
                        id: idTask,
                        id_status: idStatus
                    },
                    success: function(response) {
                        $(`.task-item[data-id=${idTask}]`).html(taskCardContent(response));
                    }
                });
            }
        });
        $(".sendMessage").click(function() {
            $.ajax({
                type: "POST",
                url: "<?php echo base_url("api/project-board/send-message"); ?>",
                data: {
                    id_task: $(this).attr("data-id"),
                    message: $("#messageInput").val()
                },
                success: function(response) {
                    let detail = $(".detailBody").html();
                    detail += taskDetail(response);
                    $(".detailBody").html(detail);
                }
            });
        });
        $("body").on("click", ".task-item", function() {
            let id = $(this).attr("data-id");
            $(".sendMessage").attr("data-id", id);
            $("#description").html($(this).attr("data-description"));
            getDetail(id);
            $("#modalDetail").modal("show");
        });
    });
    // $( ".sortable" ).disableSelection();
</script>