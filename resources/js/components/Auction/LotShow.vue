<template>
    <div class="container">
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
        <div class="row no-gutters">

            <div class="col-12 col-sm-6 col-md-5">
                <img class="card-img-top scale"
                     style="height: 300px; width: 300px; display: block; "
                     :src="pathImag"
                     data-holder-rendered="true">
            </div>
            <div class="col-md-7">
                <ul class="list-group">
                    <li class="list-group-item">Название: {{lot.name}}</li>
                    <li class="list-group-item">Описание: {{lot.description}}</li>
                    <li class="list-group-item">Актуальная ставка: {{updateBet}} рублей</li>
                    <li class="list-group-item">Дата окончания торгов: {{lot.timeLeft}}</li>
                    <li class="list-group-item" >Ставка<input type="text" name="" class="form-control" v-model="bet"></li>
                    <li @click="update"  v-if="auth" class="list-group-item"><button type="submit" class="btn-primary">Сделать ставку</button></li>
                    <li class="list-group-item" v-else="auth">Для ставки необходимо <a :href="loginUrl">войти</a></li>
                </ul>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props:['lot', 'user_id', 'auth'],
        data(){
            return {
                errors: [],
                flash_success: [],
                pathImag: 'http://auction/storage/' + this.lot.pathImage,
                bet_on_lot: null,
                bet: null,
                loginUrl: 'http://auction/login',
            }
        },
        mounted(){
            Echo.channel('lot-change')
                .listen('OfferBetChange', (offer) => {
                    this.updateBetOnLot(offer);
                });
        },
        computed: {
            updateBet: function (){
                return this.bet_on_lot ? this.bet_on_lot : this.lot.offer.bet_on_lot;
            }
        },
        methods:{
            async update(){
                try {
                    this.errors = [];
                    this.flash_success = [];

                    const response = await window.axios({
                        method: 'put',
                        url: `/api/offers/${this.lot.offer.id}`,
                        data: {
                            bet_on_lot: this.bet,
                            user_id: this.user_id,
                        }
                    });
                    this.lot.offer.bet_on_lot = this.bet;
                    this.bet = null;
                    this.flash_success = 'Ставка принята.'
                } catch (e) {
                    if(e.response.status === 422){
                        e.response.data.errors.bet_on_lot.forEach(error => {
                            this.errors.push(error)
                        });//Как обрабатывать не отдельно :(
                    }
                    if(e.response.status === 403){
                        this.errors.push(e.response.data.message);
                    }
                }
            },
            updateBetOnLot(offer){
                this.bet_on_lot = offer.offer.bet_on_lot;
            }
        }
    }
</script>

<style>
    .scale {
        transition: 1s; /* Время эффекта */
    }
    .scale:hover {
        transform: scale(1.2); /* Увеличиваем масштаб */
    }
</style>
