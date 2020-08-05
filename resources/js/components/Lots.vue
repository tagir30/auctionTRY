<template>
    <div class="row">

        <select class="form-control" id = 'bet_id'>
        <option
            v-bind="lots"
            v-for = "lot in lots"
            :value = 'lot.offer_id'
            :key = 'lot.offer_id'
        >Название: {{lot.name}}, Описание: {{lot.description}}</option>
        </select>

        <fast-bet></fast-bet>


        <br>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Фото</th>
                <th>Название лота</th>
                <th>Описание</th>
                <th>Ставка</th>
                <th>Дата закрытия принятия ставок</th>
            </tr>
            </thead>
            <tbody>
            <lot-component
                :key='lot.offer_id'
                v-bind="lot"
                v-for="lot in lots"
            ></lot-component>
            </tbody>
        </table>

    </div>
</template>
<script>
    function Lot({name, description, timeLeft, pathImage, offer: {
            bet_on_lot,
            id: offer_id,
            created_at,
    },}) {
        this.offer_id = offer_id;
        this.name = name;
        this.description = description;
        this.bet_on_lot = bet_on_lot;
        this.timeLeft = timeLeft;
        this.pathImage = 'http://auction/storage/' + pathImage;
        this.created_at = created_at;
    }

    export default {
        data() {
            return {
                lots: [],
            }
        },
        created() {
            this.read();
        },
        methods: {
            async read() {

                const {data} = await window.axios.get('/api/offers');
                data.forEach(lot => this.lots.push(new Lot(lot)));


            },
        }
    }
</script>
