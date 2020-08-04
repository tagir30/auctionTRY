<template>
    <div class="row">
        <lot-component
            :key='lot.offer_id'
            v-bind="lot"
            v-for="lot in lots"
        ></lot-component>
        <div class="d-flex justify-content-between align-items-center">
            <select class="form-control" id = 'bet_id'>
                <option
                    v-bind="lots"
                    v-for = "lot in lots"
                    :value = 'lot.offer_id'
                    :key = 'lot.offer_id'
                >{{lot.name}}</option>
            </select>
            <div class="btn-group">
                <fast-bet></fast-bet>
            </div>

        </div>
    </div>
</template>
<script>
    function Lot({name, description, timeLeft, pathImage, offer: {
            bet_on_lot,
            id: offer_id,
        },}) {
        this.offer_id = offer_id;
        this.name = name;
        this.description = description;
        this.bet_on_lot = bet_on_lot;
        this.timeLeft = timeLeft;
        this.pathImage = 'http://auction/storage/' + pathImage;
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
