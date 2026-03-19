<?php
  get_header();
?>
{% block header %}
    <header class="col col-12 p-0 m-0 pb-2">
        <div class="h1 p-0 m-0 text-windsorpro-bold">{% if header.title %}{{ header.title|e }}{% endif %}</div>
        <div class="h2 p-0 m-0 text-windsorpro-regular">{% if header.description %}{{ header.description }}{% endif %}</div>
        <hr class="border border-dark border-1 opacity-100">
    </header>
{% endblock %}

<!-- {% block header_navigation %}
    {% include 'partials/navigation.html.twig' %}
{% endblock %} -->

{% block body %}
  <main class="col col-12 p-0 m-0">
    <article class="col col-12 p-0 m-0">
      <div class="text-georgia-regular">
        {% block content %}{% endblock %}
      </div>
    </article>
  </main>
{% endblock %}

{% block bottom %}
    {{ assets.js('bottom')|raw }}
{% endblock %}
<?php
  get_footer();
?>