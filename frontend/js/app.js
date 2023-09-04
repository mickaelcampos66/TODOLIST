const app = {

  // Attribut pour mémoriser la section <ul> ou sont stockées les <li> des taches
  section: null,  // Utilisé pour mémoriser la section <ul>

  /**
   * Fonction de démarrage de l'application
   * C'est ici qu'on affiche la liste des tâches
   */
  init: async function()
  {
    const taskList = await api.getTasksList();
    app.displayTaskList(taskList);
  },

  /**
   * Méthode de gestion du click sur le bouton délete de la tâche
   * 
   * @param {*} event 
   */
  handleClickDelete:  async function (event) {
      
    // On va chercher le <ul> qui est le parent du <li>
    const cible = event.target.parentNode;
    
    // On récupère l'id de la tâche a supprimer
    const id = cible.dataset.id;
    
    // Appel de l'api de suppression de tache
    // cet api reourne le status de la requete
    // 200 = OK, 404 = Not fount, 500 = server error
    const status = await api.deleteTask(id);
    
    if (status === 200) {
      cible.remove();
    }
  },


  handleClickEdit: async function(event) {
    // On va chercher le <ul> qui est le parent du <li>
    const cible = event.target.parentNode;
    // On récupère l'id de la tâche a supprimer
    const id = cible.dataset.id;
    // On affiche la modal
    app.displayModal(true, id);
  },



  displayTask: function(task)
  {
    /*
    Dans cette méthode on constitue le bloc <li> avec les éléments suivants

    <li data-id="0">
        <p>sortir les poubelles<em>catégorie</em></p>
        <div class="delete"></div>
        <div class="edit"></div>
    </li>

    L'élément <li> est la valeur de retour de cette méthode
    */

    // Création du container <li> pour une tache
    const li = document.createElement('li');

    // Ajout de l'attribut 'data-id' initialisé avec l'id de la tache
    // Utile pour la suppression
    li.dataset.id = task.id;

    // Création du <p> pour le titre de la tâche
    const p = document.createElement('p');
    p.textContent = task.title;
    
    const em = document.createElement('em');
    p.appendChild(em);

    /*
    Variable = (Condition) ? (Valeur si condition vraie) : (valeur si condition fausse);
    L'opérateur ternaire est équivalent a un if else tel que ci-dessous
    if (task.category) {
      em.textContent = task.category.name
    } else {
      em.textContent = "Sans catégorie"
    }
    */

    em.textContent = task.category ? task.category.name : "Sans catégorie";
    
    // Création du bouton delete
    const del = document.createElement('div');
    del.classList.add('delete');
    
    // Ajout de l'evt pour supprimer la tâche
    del.addEventListener('click',app.handleClickDelete);
    
    // Création du bouton edit
    const edit = document.createElement('div');
    edit.classList.add('edit');

    // Ajout de l'event pour editer la tâche
    edit.addEventListener('click', app.handleClickEdit);
    
    // Ajout des 3 tags dans le <li>
    li.appendChild(p);
    li.appendChild(del);
    li.appendChild(edit);

    // On retourne le <li> constitué

    return li;
  },

  /**
   * Methode qui permet d'afficher ou cacher la fenetre modale de création d'une tâche
   * 
   * @param {*} isDisplayed 
   */
  displayModal: async function (isDisplayed, idTask=null)
  {
    const modal = document.querySelector('.modal-dialog');

    if (isDisplayed) {
      // Afficher la modal -> ajout de la class '.modal-dialog.show' a l'élément modal
      modal.classList.add('show')
    } else {
      // Masquer la modal -> suppression de la class '.modal-dialog.show' a l'élément modal
      modal.classList.remove('show')
    }

    if(idTask !== null) {
      const liList = document.querySelectorAll('.tasklist li');
      const taskTitle = document.querySelector('#task-title');
      for (const li of liList) {
        if (li.dataset.id == idTask){
          taskTitle.setAttribute('value');
          taskTitle.value = "lol";
        }
      }
      
    }
  },

  displayMessage: function(type, isDisplayed)
  {
    let message;

    if (type == "success") {
      // Selection du message success (class "message success")
      message = document.querySelector(".message.success")
    } else {
      // Selection du message success (class "message danger")
      message = document.querySelector(".message.danger")
    }

    if (isDisplayed) {
      message.removeAttribute('hidden');
    } else {
      message.addAttribute('hidden');
    }
  },

  createSelect: function(options)
  {
    // Selectionner le <select><select> dans le document
    const select = document.querySelector('select');
    // Faire une boucle pour insérer les options
    options.forEach(function (option) {
      const opt = new Option(option.name, option.id);
      select.add(opt);
    })

    /* // Autre méthode :
    options.forEach((option) => {
      const opt = document.createElement("option")
      opt.textContent = option.name
      opt.dataset.id = option.id
      select.appendChild(opt)
     })
     */
  },

  handleCreateTask: async function(evt)
  {
    // On va chercher le <form> dans le document
    const form = document.querySelector('.modal-dialog form');

    // Aller chercher avec l'API la liste des catégories
    const categories = await api.getCategoriesList();
    
    // Remplissage du select avec les categories récupérées
    app.createSelect(categories);

    // Reset des champs du formulaire
    form.reset();

    // On affiche la modal
    app.displayModal(true);

    // Mise en place d'un evt sur le submit form
    form.addEventListener('submit', async function (evt) {

      // Empeche l'evt submit de remonter et d'être traité normalement
      evt.preventDefault();

      // Initialisation d'un formData sur le form
      // Cela permet de récupérer les value des inputs de manière simple 
      const formData = new FormData(form)

      // On récupère le titre de la tache
      const title = formData.get('title');
      const category = formData.get('category');

      // Sauvegarde dans le BDD
      const data = await api.createTask(title);

      if (data) {
        app.displayMessage('success', true)

        // Ajouter la nouvelle tâche au DOM
        
        const li = app.displayTask({title: data.title, id: data.id})
        
        // Aller chercher la section <ul> pour ajouter la tache créée
        app.section.appendChild(li);

      } else {
        app.displayMessage('error', true)
      }

      app.displayModal(false);
    })
  },

  /**
   * Cette fonction pilote l'ajout d'une tache
   * - creation du handle click sur le bouton 'nouvelle tâche'
   * - gestion de la modal (display: none, display flex)
   */
  createTask: function()
  {
    const container = document.querySelector('.create-task-container');
    const button = container.querySelector('button');

    // Ajouter le handle de click
    button.addEventListener('click', app.handleCreateTask);
  },


  displayTaskList: function(taskList)
  {
    // Récupération de l'élément <ul> ou vont être affichées les tâches
    app.section = document.querySelector(".tasklist");

    // Vider le contenu actuel du <ul>
    app.section.textContent = '';

    for(const task of taskList) {
      // Affichage d'une tache
      const li = app.displayTask(task);
      // Ajout du <li> a la section des tâches
      app.section.appendChild(li);
    };

    // Gestion de l'ajout d'une nouvelle tâche
    app.createTask();
  }
};


document.addEventListener('DOMContentLoaded', app.init);