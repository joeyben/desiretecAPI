<template>
    <div class="confirm-popup">
            <div class="popup-body">
                <p>Are you sure?</p>
                <button class='btn btn-primary' @click='cancelEvent'>No</button>
                <button class='btn btn-primary' @click='deleteMessage'>Yes</button>
            </div>
            <input class='hidden-popup-val' type="text">
    </div>
</template>

<script>
export default {

    props: [ 'id'],
    
    methods: {
        cancelEvent() {
            $('.confirm-popup').css('display','none');
            $('body').css('overflow', 'scroll');
        },

        deleteMessage() {
            var id = $('.hidden-popup-val').val();
            axios.get('/message/delete/'+id).then(resp => {
                $('.confirm-popup').css('display','none');
                $('body').css('overflow', 'scroll');

                this.$emit('confirm');
            });
            
        },
    }
}
</script>


<style>
.confirm-popup{
    display: none;
    width: 300px;
    position: fixed;
    z-index: 9999;
    left: 0px;
    right: 0px;
    top: 35%;
    background: #FFFFFF;
    margin: 0 auto;
    border: 1px solid #ccc;
    box-shadow: 0 0 2px 0px rgba(0, 0, 0, 0.1);
}
.confirm-popup .popup-body{
    padding:20px;
    text-align:center;
}
.confirm-popup .popup-body button{
    display:inline-block
}
.hidden-popup-val{
    display: none;
}
</style>

