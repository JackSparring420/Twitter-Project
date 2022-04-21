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
                    <label>Add Images:</label>
                    <input type="file" name="tweet_img" @change="saveImg" class="form-control">
                </div>
                <div class="form-group align-self-end">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                        Programma pubblicazione
                    </button>
                </div>
            </div>
                    <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="scheduling" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="scheduling">Programma pubblicazione</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <label>Publication Date:</label>
                        <input type="datetime-local" name="tweet_date" multiple class="form-control" v-model="date" :min="date">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-bs-target="#scheduling" data-dismiss="modal">OK</button>
                    </div>
                    </div>
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
        tweet_img: '',
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
    // save form image
    saveImg(img) {
        this.tweet_img = img.target.files[0];
        console.log("tweet_img:", this.tweet_img);
    },
    // submit create tweet - form
    submitTweet(e) {
        let form = new FormData(e.target);
            form.append("tweet_description", this.text);
            form.append("tweet_date", this.date);
            form.append("tweet_img",this.tweet_img);  

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
        //refresh
        this.text = '';
        // window.location.href = '/profile';
        // send to twitter
        // if(this.date.getTime() == now().getTime()){

        // }
    }
}
}
</script>