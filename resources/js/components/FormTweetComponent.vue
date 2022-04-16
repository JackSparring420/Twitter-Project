<template>
    <section>
        <FormErrorComponent v-if="validationErrors" :errors="validationErrors"/>
        <form id="edit_form" method="POST" enctype="multipart/form-data" @submit.prevent="submitTweet" class="form-tweet">
            <div class="form-group">
                <label>Add Tweet Text:</label>
                <textarea class="form-control" name="tweet_description" v-model="text"></textarea>
            </div>
            <div class="container row justify-content-between">
                <div class="form-group">
                    <label>Add Multiple Images:</label>
                    <input type="file" name="tweet_img" multiple class="form-control">
                </div>
                <div class="form-group">
                    <label>Publication Date:{{date}}</label>
                    <input type="datetime-local" name="tweet_date" multiple class="form-control" @click="now()" v-model="date" :min="now()">
                </div>
            </div>
            <div class="form-group">
                <button class="btn btn-success">Add New Tweet</button>
            </div>
        </form>

    </section>
</template>

<script>
import FormErrorComponent from './FormErrorComponent.vue';
    let today = new Date();
    let currentMonth = (today.getMonth()+1);
    let currentDay = today.getDate();
    let currentHours = today.getHours();
    let currentMinutes = today.getMinutes();
    if (currentMonth < 10) { currentMonth = '0' + currentMonth;};
    if (currentDay < 10) { currentDay = '0' + currentDay;};
    if (currentHours < 10) { currentHours = '0' + currentHours;};
    if (currentMinutes < 10) { currentMinutes = '0' + currentMinutes;};
    let date = today.getFullYear()+'-'+currentMonth+'-'+currentDay;
    let time = currentHours + ":" + currentMinutes;
    let dateTime = date+'T'+time;

export default {
components: { 
        FormErrorComponent,
    },
data: function(){
    return{
        text: '',
        date: dateTime,
        hour: '',

        newTweets: [],
        validationErrors: '',
    }
},
components: {
    FormErrorComponent,
},
props: {
    tweets: Array
},
mounted(){
    // this.date = new Date();
    this.hour = new Date();
},
methods: {
    // stamp date for value
    now(){
        let today = new Date();
        let currentMonth = (today.getMonth()+1);
        let currentDay = today.getDate();
        let currentHours = today.getHours();
        let currentMinutes = today.getMinutes();
        if (currentMonth < 10) { currentMonth = '0' + currentMonth;};
        if (currentDay < 10) { currentDay = '0' + currentDay;};
        if (currentHours < 10) { currentHours = '0' + currentHours;};
        if (currentMinutes < 10) { currentMinutes = '0' + currentMinutes;};
        let date = today.getFullYear()+'-'+currentMonth+'-'+currentDay;
        let time = currentHours + ":" + currentMinutes;
        let dateTime = date+'T'+time;
        return dateTime
    },
    // submit create tweet - form
    submitTweet(e) {
        let form = new FormData(e.target);
            form.append("tweet_description", this.text);
            form.append("tweet_date", this.date);
        // post form 
        axios.post('/createVue', form)
            .then(response => {
                this.newTweets = this.tweets;
                this.newTweets.unshift(response.data);
                console.log(this.newTweets);
                this.$emit("getNewTweets", this.newTweets);
        })
            .catch(error => {
                if(error.response.status == 422) {
                    this.validationErrors = error.response.data.errors
                }
        });
        // send to twitter
        // if(this.date.getTime() == now().getTime()){

        // }
    }
}
}
</script>