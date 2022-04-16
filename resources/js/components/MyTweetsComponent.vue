<template>
    <section>

        <FormTweetComponent 
            :tweets="tweets"
            @getNewTweet="getNewTweet"
        />

        <div v-for="tweet in tweets" :key="tweet.id" class="post" >
            <div :class="new Date(tweet.tweet_date).getTime() > date ? 'opacity' : ''">
                <div class="post__header">
                    <div class="post-meta">                    
                        <div class="post-meta__icon">
                            <img class="profile-pic" src="https://unsplash.it/300/300?image=15" >                    
                        </div>
                        <div class="post-meta__data">
                            <div class="post-meta__author">Emanuele Arconte</div>
                            <div class="post-meta__time">{{format(tweet.tweet_date)}}</div>
                        </div>                    
                    </div>
                </div>
                <div class="post__text" v-html="autoLinked(tweet.tweet_description)"></div>
                <div class="post__image">
                    <img :src="tweet.tweet_img" alt="">
                </div>
                <div class="post__footer">
                    <div class="likes js-likes">
                        <div class="likes__cta">
                            <span class="like-button  js-like-button" data-postid="${i}">
                                <i class="like-button__icon fas fa-thumbs-up" aria-hidden="true"></i>
                                <span class="like-button__label">Mi Piace</span>
                            </span>
                        </div>
                        <div class="likes__counter">
                            Piace a <b id="like-counter-1" class="js-likes-counter">{{tweet.tweet_likes}}</b> persone
                        </div>
                    </div> 
                </div>            
            </div>
            <button type="button" class="btn btn-primary delete_tweet" data-toggle="modal" data-target="#exampleModal" v-if="new Date(tweet.tweet_date).getTime() > date">
                <i class="fas fa-trash-alt"></i>
            </button>

            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">ELIMINA</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Vuoi eliminare il post?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">NO</button>
                        <button type="button" class="btn btn-primary" data-dismiss="modal" @click="deleteTweet(tweet.id)">SI</button>
                    </div>
                    </div>
                </div>
            </div>
        
        </div>

    </section>
</template>

<script>
import { autoLink } from 'vue-highlights';
import { format } from 'date-fns';
import FormTweetComponent from './FormTweetComponent.vue';

export default {
components: { 
        FormTweetComponent,
    },
data: function(){
    return{
        tweets: [],
        date: '',
        text: '#funzioni?',
                
    }
},
mounted(){
    // get tweets on my DB
    axios.get('/MyTweets')
        .then(r => {
            this.tweets = r.data;
            console.log(r.data);
            });
    this.date = new Date().getTime();

},
methods:{
    // get new tweet
    getNewTweet(getNewTweet){
        this.tweets = getNewTweet;
        console.log('ciaooo');
    },
    // highlight text
    autoLinked(text){
        return autoLink(text) 
    },
    // format date
    format(date){
    return format(new Date(date), "dd/MM/yyyy  HH:mm")
    },
    // delete dish
    deleteTweet(id) {
            axios.post(`/delete/${id}`)
            .then(res => { 
                const tweet = res.data;
                let tweetInd = this.getTweetById(tweet.id);
                this.tweets.splice(tweetInd, 1); 
            })

    },
    // get tweet index to delete
    getTweetById(id){
        for (let i = 0; i < this.tweets.length; i++) {
            const tweet = this.tweets[i];
            if (tweet.id == id) {
                return i;
            }
        }
        return -1
    }
}
}
</script>