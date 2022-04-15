<template>
    <section>
        <!-- <form action="">
            <div class="form-group">
                <label>Add Tweet Text:</label>
                <textarea class="form-control" name="tweet_description"></textarea>
            </div>
            <div class="form-group">
                <label>Add Multiple Images:</label>
                <input type="file" name="tweet_img" multiple class="form-control">
            </div>
            <div class="form-group">
                <label>Publication Date:</label>
                <input type="date" name="tweet_date" multiple class="form-control" value="{{$current->format('Y-m-d')}}" min="{{$current->format('Y-m-d')}}">
            </div>
            <div class="form-group">
                <button class="btn btn-success">Add New Tweet</button>
            </div>
        </form> -->
        <div v-for="tweet in tweets" :key="tweet.id" class="post" >
            <div :class="new Date(tweet.tweet_date).getTime() >  date ? 'opacity' : ''">
                <div class="post__header">
                    <div class="post-meta">                    
                        <div class="post-meta__icon">
                            <img class="profile-pic" src="https://unsplash.it/300/300?image=15" >                    
                        </div>
                        <div class="post-meta__data">
                            <div class="post-meta__author">Emanuele Arconte</div>
                            <div class="post-meta__time">{{tweet.tweet_date}}</div>
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
         <div class="my-linked-text">
        </div>
        
        </div>
    </section>
</template>

<script>
import { autoLink } from 'vue-highlights';

export default {
data: function(){
    return{
        tweets: [],
        date: '',
        text: '#funzioni?',
                
    }
},
mounted(){
    axios.get('/MyTweets')
        .then(r => {
            this.tweets = r.data;
            console.log(r.data);
            });
    this.date = new Date().getTime() ;
},
methods:{
    autoLinked(text){
        return autoLink(text) 
    }
}
}
</script>