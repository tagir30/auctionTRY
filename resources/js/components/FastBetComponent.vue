<template>
    <div>
    <p v-if="errors.length">
        <b>Пожалуйста исправте указанные ошибки</b>
        <ul>
            <li v-for="error in errors">
            {{error}}
            </li>
        </ul>
    </p>
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
                    <h2 class="modal-title">Быстрая ставка</h2>
                    <button type="button" class="close btn" data-dismiss="modal">&times;</button>
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
                errors: [],
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
                }catch (error) {
                    error.response.data.errors.bet_on_lot.forEach(error =>{
                        this.errors.push(error)
                    });//Как обрабатывать не отдельно :(
                }

            }
        }
    }
</script>
