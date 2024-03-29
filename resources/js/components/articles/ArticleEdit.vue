<template>
    <h1>modifier l'article</h1>
    <div v-if="errors">
        <div v-for="(v,k) in errors" :key="k">
            <p v-for="error in v" :key="error">
              {{ error }}
            </p>

        </div>
    </div>

    <form v-on:submit.prevent="saveArticle">
        <label for="title">Titre</label>
        <input type="text" name="title" id="title" v-model="article.title">
        <br>
        <br>
        <label for="content">Description</label>
        <textarea name="content" id="content" cols="30" rows="10" v-model="article.content"></textarea>
        <br>
        <br>
        <label for="image">Image</label>
        <input type="file" @change="getImage" :required="false">

        <button type="submit">Save</button>
    </form>
</template>

<script setup>
import useArticles from '../../composables/articles';
import {onMounted} from 'vue';

const { errors, article, updateArticle, getArticle } = useArticles()

const props = defineProps({
    id: {
        required: true,
        type: String
    }
})

const getImage = (event) => {
    article.image = event.target.files[0];
    console.log(article.image = event.target.files[0])
};



onMounted(() => getArticle(props.id))


const saveArticle = async () => {
       
    await updateArticle(props.id)
}

</script>