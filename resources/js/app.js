import './bootstrap';
import { createApp } from 'vue';
import router from './router';

import ArticleList from './components/articles/ArticleList.vue';


/* start application vue */
createApp({
    components:{
        ArticleList
    }
}).use(router).mount('#app')