<template>
    <div class="row">

        <select class="form-control" id='bet_id' >
            <option selected>
                Выберите лот
            </option>
            <option
                :key='lot.offer_id'
                :value='lot.offer_id'
                v-bind="lots"
                v-for="lot in lots"
            >Название: {{lot.name}}, Описание: {{lot.description}}, Текущая ставка: {{lot.bet_on_lot}} рублей
            </option>
        </select>

        <fast-bet @bet="onBet" v-if="auth" :user_id="user_id"></fast-bet>
        <h3 v-else="auth">Для ставки необходимо <a :href="loginUrl">войти</a></h3>


        <br>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Фото</th>
                <th>Название лота</th>
                <th>Описание</th>
                <th>Ставка</th>
                <th>Дата закрытия ставок</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <lot-table-component
                :key='lot.offer_id'
                v-bind="lot"
                v-for="lot in lots"
            ></lot-table-component>
            </tbody>
        </table>

    </div>
</template>
<script>
    function Offer({name, description, timeLeft, pathImage, offer: {
            bet_on_lot,
            id: offer_id,
            created_at,
        },
                 }) {
        this.offer_id = offer_id;
        this.name = name;
        this.description = description;
        this.bet_on_lot = bet_on_lot;
        this.timeLeft = timeLeft;
        this.pathImage = 'http://auction/storage/' + pathImage;
        this.created_at = created_at;
    }

    export default {
        props:['auth', 'user_id'],
        data() {
            return {
                lots: [],
                loginUrl: 'http://auction/login',
            }
        },
        mounted(){
            Echo.channel('lot-change')
                .listen('OfferStatusChanged', (lot) => {
                    this.refreshOffer(lot);
                });
            this.read();

        },
        methods: {
            async read() {
                this.lots = [];
                const {data} = await window.axios.get('/api/offers');
                data.forEach(offer => this.lots.push(new Offer(offer)));
            },
            onBet(data) {
                this.lots.map(lot => {
                    if (lot.offer_id == data.offer_id) {
                        lot.bet_on_lot = data.bet_on_lot;
                    }
                });
            },
            refreshOffer(offer){
                console.log(this.lots);
                const index = this.lots.map(lot => {
                    console.log(lot.offer_id);
                    return lot.offer_id;
                }).indexOf(offer.offer_id);
                console.log(index);

                if(index !== -1){
                    console.log('this delete');
                    this.lots.splice(index, 1);
                }
                if(index === -1){
                    console.log('this push');
                    this.lots.push(new Offer(offer))
                }
            }

        }
    }
</script>
