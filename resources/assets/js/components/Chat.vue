<template>
  <v-layout row>
    <v-flex xs12 sm6 offset-sm3>
      <v-card class="chat-card" dark="">
        <v-list>
          <v-subheader
            >
              Group Chat
            </v-subheader>
            <v-divider></v-divider>
            <v-list-tile
              class="p-3"
              v-for="(message, index) in allMessages" 
              :key="index"
            >

           <v-layout 
           :align-end="(user.id!==message.user.id)" 
            column
           >
             <v-flex>
               <v-layout column>
                  <v-flex>
                    <span class="small font-italic">{{message.user.name}}</span>
                  </v-flex>

                  <v-flex>
                    <v-chip
                      :color="(user.id!==message.user.id)?'red':'green'"
                      text-color="white"
                    >

                      <v-list-tile-content >
                        {{message.message}}
                      </v-list-tile-content>
                    </v-chip>
                  </v-flex>

                  <v-flex class="caption font-italic">
                    {{message.created_at}}
                  </v-flex>
               </v-layout>
             </v-flex>
           </v-layout>


            </v-list-tile>
        </v-list>
      </v-card>




    </v-flex>

    
      <v-footer
      height="auto"
      fixed
      color="grey"
      >
      <v-layout row >
        <v-flex xs6 offset-xs3 justify-center align-center>
            <v-text-field
              rows=2
              v-model="message"
              label="Enter Message"
              single-line
              @keyup.enter="sendMessage"
            ></v-text-field>
        </v-flex>

        <v-flex xs2> 
            <v-btn 
              @click="sendMessage"
             dark class="mt-3 ml-2 white--text" small color="green">send</v-btn>
        </v-flex>
      </v-layout>
      
          
    </v-footer>
  </v-layout>
</template>

<script>
  export default {
    props:['user'],
    
    data () {
      return {
        message:null,
        allMessages:[]
      }
    },

    methods:{
      sendMessage(){

        //check if there message
        if(!this.message){
          return alert('Please enter message');
        }

          axios.post('/messages', {message: this.message}).then(response => {
                    this.message=null;
                    this.allMessages.push(response.data.message)
                    setTimeout(this.scrollToEnd,100);
          });
      },
      fetchMessages() {
            axios.get('/messages').then(response => {
                this.allMessages = response.data;

            });
        },

      scrollToEnd(){
        window.scrollTo(0,99999);
      }

    
    },

    mounted(){
    },

    created(){
      this.fetchMessages();

      Echo.private('lchat')
      .listen('MessageSent',(e)=>{
          this.allMessages.push(e.message)
          setTimeout(this.scrollToEnd,100);

      });

    }
    
  }
</script>

<style scoped>
.chat-card{
  margin-bottom:140px;
}
</style>
