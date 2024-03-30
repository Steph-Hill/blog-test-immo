import { ref } from "vue";
import axios from "axios";
import { useRouter } from "vue-router";

export default function useArticles() {

    const article = ref([])
    const articles = ref([])

    const errors = ref('')
    const router = useRouter()

    const gallery = ref([])

    const getArticles = async () => {
        let response = await axios.get('/api/articles')
        articles.value = response.data.data
    }

    const getArticle = async (id) => {
        let response = await axios.get(`/api/articles/${id}`)
        article.value = response.data.data
    }

    const storeArticle = async (formData, data) => {
        errors.value = ''
        try {
            await axios.post('/api/articles', formData, data,{
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            });
            await router.push({name: 'article.list'});
        } catch (e) {
            if (e.response.status === 422) {
                for(const key in e.response.data.errors){
                    errors.value = e.response.data.errors;
                }
            }
        }
    }
    const updateArticle = async (id,gallery) => {

        errors.value = ''
        
        try{
            await axios.put(`/api/articles/${id}`, article.value,{
                gallery:gallery.value,
            })
            
            await router.push({name: 'article.list'})
        }catch (e) {if (e.response.status === 422) {
            for(const key in e.response.data.errors){
                errors.value = e.response.data.errors;
            }
        }
            
        }
    }

    const destroyArticle = async(id) => {
        await axios.delete(`/api/articles/${id}`)
    }

    return {
        errors,
        article,
        gallery,
        articles,
        getArticle,
        getArticles,
        storeArticle,
        updateArticle,
        destroyArticle,
    }
}
