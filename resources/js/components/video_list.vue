<template>

  <div>
    This is the video list.

    <div>
      <table class="table">
        <thead>
          <tr>
            <th>Views</th>
            <th>Likes</th>
            <th>Dislikes</th>
            <th>
              Score
              <i class="fas fa-question-circle" title="Equation: (log(base10,views) * likes/dislikes)"></i>
            </th>
            <th>Video Title</th>
            <th>Owner</th>
            <th>Published</th>
            <th><i class="fab fa-youtube" title="Links"></i></th>
          </tr>
        </thead>
        
        <tr v-for="v in videos" v-bind:key="v.id">
          <td>views</td>
          <td>likes</td>
          <td>dislikes</td>
          <td>score</td>
          <td><a href="/videos/id">title</a></td>
          <td><a href="/channels/cid">owner</a></td>
          <td>published 'M Y'</td>
          <td>
            <a href="https://www.youtube.com/watch?v=vid" target="_blank"><i class="fas fa-video" title="Visit video" ></i></a>
            <a href="https://www.youtube.com/channel/cid" target="_blank"><i class="far fa-smile" title="Visit channel"  ></i></a>
          </td>
        </tr>
      </table>          
      
    </div>
  </div>
</template>

<script>

</script>

<style>
</style>
