<template>
  <nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
      <button class="navbar-toggler hidden-sm-up" type="button" data-toggle="collapse" data-target="#exCollapsingNavbar2">
        &#9776;
      </button>
      <div class="collapse navbar-toggleable-xs" id="exCollapsingNavbar2">
        <a class="navbar-brand" href="">Linguissime</a>
  
        {% if not is_granted('IS_AUTHENTICATED_FULLY') %}
        <ul class="nav navbar-nav pull-xs-right">
          <li class="nav-item"><a href="{{ path('register') }}" class="nav-link">Inscription</a></li>
          <li class="nav-item"><a href="{{ path('login') }}" class="nav-link">Connexion</a></li>
        </ul>
        {% else %}
        <ul class="nav navbar-nav pull-xs-right">
          <li class="nav-item" style="padding-top:2px;"><a href="" class="nav-link">30 <i style="padding-left:3px; color:#F4D03F;" class="fa fa-trophy" aria-hidden="true"></i></a></li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
              <img src="https://media.licdn.com/mpr/mpr/shrinknp_200_200/p/2/000/1a2/1ce/0ad60d0.jpg" class="m-r-5 img-circle" width="25" heigth="25">
                Antoine
              </a>
              <div class="dropdown-menu" aria-labelledby="Preview">
                <a class="dropdown-item"  href="{{ path('change_account') }}"> <i class="fa fa-cog" style="padding-right: 16px;" aria-hidden="true"></i>Paramètres</a>
                <a class="dropdown-item"  href="#"> <i class="fa fa-tasks" aria-hidden="true" style="padding-right: 14px;"></i>Créer un exercice</a>
                <a class="dropdown-item"  href="{{ path('logout') }}"> <i class="fa fa-power-off" style="padding-right: 16px;" aria-hidden="true"></i>Déconnexion</a>
              </div>
            </li>
        </ul>
  
        <form class="form-inline pull-xs-left m-l-15">
          <div class="inner-addon right-addon">
            <i class="fa fa-search" aria-hidden="true"></i>
            <input class="form-control" type="text">
          </div>
        </form>
            {% endif %}
      </div>
    </div>
  </nav>
</template>
<script>
</script>
<style src="stylesheets/bootstrap.css"></style>
    