<template>
    <div class="container">
        <div class="row no-gutters">
            <div class="col-12 col-sm-6 col-md-5">
                <img class="card-img-top"
                     style="height: 300px; width: 300px; display: block;"
                     :src="pathImag"
                     data-holder-rendered="true">
            </div>
            <div class="col-md-7">
                <ul class="list-group">
                    <li class="list-group-item">Название: {{lot.name}}</li>
                    <li class="list-group-item">Описание: {{lot.description}}</li>
                    <li class="list-group-item">Актуальная ставка: {{lot.offer.bet_on_lot}} рублей</li>
                    <li class="list-group-item">Дата окончания торгов: {{lot.timeLeft}}</li>
                    <li class="list-group-item">Ставка<input type="text" name="" class="form-control" v-model="bet_value"></li>
                    <li @click="bet" class="list-group-item"><button type="submit" class="btn-primary">Сделать ставку</button></li>

                </ul>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props:['lot'],
        data(){
            return {
                pathImag: 'http://auction/storage/' + this.lot.pathImage,
                bet_value: '',
            }
        },
        mounted(){
            // this.read();
        },
        methods:{
            bet(){
                alert(this.bet_value);
            }

        }
    }
</script>
