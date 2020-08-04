<template>
    <div>

    <!-- Button to Open the Modal -->
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
        Сделать быструю ставку
    </button>

    <!-- The Modal -->
    <div class="modal" id="myModal">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Быстрая ставка</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <label>Введите ставку:</label>
                    <input type="text" v-model="bet">
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal" @click="update">Поставить</button>
                </div>

            </div>
        </div>
    </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                bet: 0,
            }
        },
        methods:{
            async update() {
                try {
                    const el = document.getElementById('bet_id');
                    const offer = el.value;
                    const response = await window.axios({
                        method: 'put',
                        url: `/api/offers/${offer}`,
                        data: {
                            bet_on_lot: this.bet,
                        }});
                    // const response = await window.axios.put(`/api/offers/${offer}`,{
                    //     bet: this.bet,
                    //     _method: ''
                    // });
                    console.log(response);
                }catch (e) {
                    console.error(e)
                }

            }
        }
    }
</script>
