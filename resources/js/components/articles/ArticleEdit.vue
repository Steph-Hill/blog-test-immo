<template>
    <h1>modifier l'article</h1>
    <div v-if="errors">
        <div v-for="(v, k) in errors" :key="k">
            <p v-for="error in v" :key="error">
                {{ error }}
            </p>

        </div>
    </div>

    <form action="" v-on:submit.prevent="saveArticle" enctype="multipart/form-data">
        <label for="title">Titre</label>
        <input type="text" name="title" id="title" v-model="article.title">
        <br>
        <br>
        <label for="content">Description</label>
        <textarea name="" id="" cols="30" rows="10" v-model="article.content"></textarea>
        <br>
        <br>
        <label for="image" v-if="article.image">Image existante :</label>
        <img v-if="article.image" :src="article.image" alt="Image existante">
        <label for="image">Image (nouvelle) :</label>
        <input type="file" name="image" @change="updateImage">
        <button type="submit">Save</button>
    </form>
</template>

<script setup>
import useArticles from '../../composables/articles';
import { onMounted, ref } from 'vue';

const { errors, article, updateArticle, getArticle } = useArticles()


const props = defineProps({
    id: {
        required: true,
        type: String
    }
})
const image = ref(null)

onMounted(() => {
    getArticle(props.id)
    image.value = article.image;
}) 

const updateImage = (event) => {
    image.value = event.target.files[0]
  console.log('update image : ',image.value )
  console.log('event update:',event)

}

const saveArticle = async () => {
    const formData = new FormData();
    
    formData.append('title', article.value.title);
    console.log('formdata title :',article.value.title)
   
    formData.append('content', article.value.content);
    console.log('formdata content :',article.value.content)

    if (image.value !== null) {
        console.log('image Article :',image.value)
       
        formData.append('image', image.value);
        console.log('formdata image',image.value)
    }
    await updateArticle(props.id, formData);
    console.log('updateArticle :',updateArticle)
}
console.log('savearticle',saveArticle)
</script>