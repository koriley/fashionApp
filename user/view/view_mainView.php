<?php ?>
<div class="row">
    <div class="col-md-8 col-md-offset-2 redTop" >
        <h1>My Events</h1>
        <div class="row">
            <div class="eventList col-md-10 col-md-offset-1" style=" "></div>
        </div>
        <div class="row">
            <div class="refreshList pull-right col-md-3">
                <button id="refreshButton">Refresh Events</button>
            </div>
        </div>
    </div>

</div>

<script>
    jQuery('#refreshButton').click(function() {
        jQuery('#mother').load('view/view_mainView.php');
    });
</script>