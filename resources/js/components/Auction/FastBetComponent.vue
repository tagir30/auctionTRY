<template>
    <div>
        <div v-if="errors.length">
            <b>Пожалуйста исправте указанные ошибки</b>
        <ul class="alert-danger">
            <li v-for="error in errors">
                {{error}}
            </li>
        </ul>
        </div>
        <div v-if="flash_success.length" class="alert alert-success">
            <strong>{{flash_success}}</strong>
        </div>
        <!-- Button to Open the Modal -->
        <button class="btn btn-primary" data-target="#myModal" data-toggle="modal" type="button">
            Сделать быструю ставку
        </button>

        <!-- The Modal -->
        <div class="modal" id="myModal">
            <div class="modal-dialog">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h2 class="modal-title">Быстрая ставка</h2>
                        <button class="close btn" data-dismiss="modal" type="button">&times;</button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">
                        <label>Введите ставку:</label>
                        <input type="text" v-model="bet">
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button @click="update" class="btn btn-danger" data-dismiss="modal" type="button">Поставить
                        </button>
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
                flash_success: [],
            }
        },
        methods: {
            async update() {
                try {
                    this.errors = [];
                    this.flash_success = [];

                    const el = document.getElementById('bet_id');
                    const offer = el.value;
                    const response = await window.axios({
                        method: 'put',
                        url: `/api/offers/${offer}`,
                        data: {
                            bet_on_lot: this.bet,
                        }
                    });
                    this.$emit('bet', {
                        offer_id: offer,
                        bet_on_lot: this.bet,
                    });
                    this.flash_success = 'Ставка принята.'
                } catch (error) {
                    error.response.data.errors.bet_on_lot.forEach(error => {
                        this.errors.push(error)
                    });//Как обрабатывать не отдельно :(
                }

            }
        }
    }
</script>
