<template>
        <tr>
            <td>
                <a :href = "showOffer">
                    <img data-holder-rendered="true"
                         :src="pathImage"
                         style="height: 90px; width: 90px; display: block;">
                </a>
            </td>
            <td>{{name}}</td>
            <td>{{description}}</td>
            <td>{{bet_on_lot}} рублей</td>
            <td>{{timeLeft}}</td>
            <a :href = "showOffer"><button class="btn btn-primary">Посмотреть поближе</button></a>

        </tr>

<!--    <div class="col-md-4">-->
<!--&lt;!&ndash;        <div class="card mb-4 box-shadow">&ndash;&gt;-->
<!--            <img class="card-img-top"-->
<!--                 data-holder-rendered="true"-->
<!--                 :src="pathImage"-->
<!--                 style="height: 225px; width: 100%; display: block;">-->
<!--            <div class="card-body">-->


<!--            </div>-->
<!--        </div>-->

<!--    </div>-->
</template>

<script>
    export default {
        props: ['offer_id', 'name', 'description', 'bet_on_lot', 'timeLeft', 'pathImage', 'created_at'],
        data() {
            return {
                showOffer: `/offers/${this.offer_id}`,
            }

        },

    }
</script>
