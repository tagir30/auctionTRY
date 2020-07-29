<!--<template>-->
<!--    <p>{{ currentTime }}</p>-->
<!--</template>-->

<!--<script>-->
<!--    export default {-->
<!--        data() {-->
<!--            return {-->
<!--                currentTime: 5,-->
<!--                timer: null-->
<!--            }-->
<!--        },-->
<!--        mounted() {-->
<!--            this.startTimer()-->
<!--        },-->
<!--        destroyed() {-->
<!--            this.stopTimer()-->
<!--        },-->
<!--        methods: {-->
<!--            startTimer() {-->
<!--                this.timer = setInterval(() => {-->
<!--                    this.currentTime&#45;&#45;-->
<!--                }, 1000)-->
<!--            },-->
<!--            stopTimer() {-->
<!--                clearTimeout(this.timer)-->
<!--            },-->
<!--        },-->
<!--        watch: {-->
<!--            currentTime(time) {-->
<!--                if (time === 0) {-->
<!--                    this.stopTimer()-->
<!--                }-->
<!--            }-->
<!--        },-->
<!--    }-->
<!--</script>-->
