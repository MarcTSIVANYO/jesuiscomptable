<script>


      var notif_panel_cleaner=1;
      function alert2(msg , statement2 , iconn , eff)
      {
        if(notif_panel_cleaner==1)
        {
        $("#notifications-top-center").remove();
        msg= '<div id="notifications-top-center" class="'+statement2+'"><i class="fa '+iconn+'" ></i> '+msg+'<div class="btn  pull-right btn-flat fermeture_alert" onclick="$(this).parent(\'div\').remove();" style="margin: 7px; " ><i class="fa fa-close (alias)" title="fermer" ></i></div></div>';
        $("#hh").append(msg);


        $("#notifications-top-center").addClass('animated '+eff);


          setTimeout( function() { $("#notifications-top-center").addClass('animated ' + 'fadeOut'); $("#notifications-top-center").remove(); notif_panel_cleaner=1; }  ,3000)
          notif_panel_cleaner=0;
        }

      }



      function alert_success(msg)
      {
       alert2(msg,'bien' , 'fa-check' ,'fadeIn');
       $('#reseter').click();
       $('#rules').val('');
     }


     function alert_notif(msg)
     {
      alert2(msg,'normal' , 'fa-lightbulb-o' ,'bounceInUp');
     }

    function alert_erreur(msg)
    {
      alert2(msg,'mauvais' ,'fa-warning' ,'bounceInUp');
    }
            //add by media soft
           // ouvrir_liste('/');


            $(function () {

             @if (Session::has('flash_notice'))
             alert_success("<?php echo Session::get('flash_notice') ?>");
             @endif

             @if (Session ::has('flash_error'))
             alert_erreur("<?php echo Session::get('flash_error') ?>");
             @endif

             @if ($errors->count() > 0)
             <?php $msg=''; foreach($errors->all() as $message) $msg=$msg.''.$message.'<br/>'; ?>
             alert_error("<?php echo $msg; ?>");
             @endif

           });


            function supprimer_enregistrement(_token,url,liste,message,param)
            {
              if(param===undefined) param=0;
              if(message===undefined) message='{{trans('message.voulezvoussupprimer')}}';
              $.confirm({
                title: '{{trans('message.confirmation')}}!',
                content: message,
                confirmButton: '{{trans('message.oui')}}',
                cancelButton: '{{trans('message.non')}}',
                animation: 'top',
                confirmButtonClass: 'btn-primary btn-flat',
                cancelButtonClass: 'btn-default btn-flat',
                confirm: function(){
                  var reqs = $.ajax({
                   url: url,
                   type: "DELETE",
                   data: {_token: _token, param: param },
                   dataType: "html"
                 });
                  afficher_chargement();
                  reqs.done(function (msg) {
                   if(msg[0]==1){
                    alert_success(msg.substr(1));
                  }
                  if(msg[0]==0){
                    alert_erreur(msg.substr(1));
                  }
                  cacher_chargement();
                  ouvrir_liste(liste);
                });

                  reqs.fail(function (jqXHR, textStatus) {
                   cacher_chargement();
                   alert_erreur('{{trans('message.lasupressionaechouee')}}');
                 });
                }

              });
            }

            var liste_opened=0;
            function ouvrir_liste(lib,param) {
            window.location=""+lib+"";
            /*
            if(liste_opened==0)
            {
             if(param===undefined) param=-1;
             var req = $.ajax({
              url: lib,
              type: "GET",
              data: {id: param},
              dataType: "html"
            });

             afficher_chargement();
             req.done(function (msg) {
              $("#conteneur").html(msg);
              set_basic_functions();
              $('.dataTable').DataTable();
              cacher_chargement();liste_opened=0;
            });

             req.fail(function (jqXHR, textStatus) {
              alert_notif('{{trans('message.connexioninterompue')}}');cacher_chargement();liste_opened=0;
            })
            }
            */
           }

           function setClientSession(id) {

              var req = $.ajax({
               url: "{{url('setsessionclient')}}",
               type: "POST",
               data: {id: id},
               dataType: "html"
             });
              afficher_chargement();
              req.done(function (msg) {
                cacher_chargement();
             });

              req.fail(function (jqXHR, textStatus) {
               alert_notif('{{trans('message.connexioninterompue')}}');cacher_chargement();liste_opened=0;
             })

            }
            $('.formulairemodal').on('submit', function(e) {
                  $('#waiting').button('loading');
                        setTimeout(function() {
                          $('#waiting').button('reset');
                       }, 15000);
                   e.preventDefault();
                   var maressource=$(this).attr('resource');
                   //mettre_a_jour_inputs();
                   var n=new FormData(this);
                   $.ajax({
                     url: $(this).attr('action'),
                     type: $(this).attr('method'),
                     dataType: "JSON",
                     data: n,
                     processData: false,
                     contentType: false,
                     success: function(html) {
                       if(html[0]==1){
                      setTimeout(function() {
                          $('#waiting').button('reset');
                       }, 1);
                         alert_success(html.substr(1));
                         ouvrir_liste(maressource);
                       }
                       if(html[0]==0){
                      setTimeout(function() {
                          $('#waiting').button('reset');
                       }, 1);
                         alert_erreur(html.substr(1));
                       }
                     },
                     error: function (xhr, desc, err) {
                       var html=xhr.responseText;
                       if(html[0]==1){
                      setTimeout(function() {
                          $('#waiting').button('reset');
                       }, 1);
                         alert_success(html.substr(1));
                         ouvrir_liste(maressource);
                       }
                       if(html[0]==0){
                      setTimeout(function() {
                          $('#waiting').button('reset');
                       }, 1);
                         alert_erreur(html.substr(1));
                       } 
                     }
                   });
                 });

           function set_basic_functions()
           {

             $('.middle-pos').children('label').on('click', function(e) {
                                         e.preventDefault();
                                             if ($(this).hasClass('active')==false)
                                             {

                                                 tmp_id_for_chk=$(this).attr('id');
                                                 $('.'+tmp_id_for_chk).each(function()
                                                 {
                                                     $(this).addClass('active');
                                                     if(!$('#l'+$(this).attr('id').substring(1)).hasClass('active'))
                                                     {
                                                         $('#l'+$(this).attr('id').substring(1)).addClass('active');
                                                     }
                                                 });

                                                 //if(!$('#l'+$('.'+tmp_id_for_chk).attr('id').substring(1)).hasClass('active'))  $('#l'+$('.'+tmp_id_for_chk).attr('id').substring(1)).click();
                                                 if($(this).hasClass('checkbox_for_all_rights'))
                                                 {
                                                    if (!$('#l'+tmp_id_for_chk.substring(1)).hasClass('active')) { $('#l'+tmp_id_for_chk.substring(1)).click(); } else { $('#l'+tmp_id_for_chk.substring(1)).click(); $('#l'+tmp_id_for_chk.substring(1)).click(); }
                                                    if (!$('#a'+tmp_id_for_chk.substring(1)).hasClass('active')) { $('#a'+tmp_id_for_chk.substring(1)).click(); } else { $('#a'+tmp_id_for_chk.substring(1)).click(); $('#a'+tmp_id_for_chk.substring(1)).click(); }
                                                    if (!$('#m'+tmp_id_for_chk.substring(1)).hasClass('active')) { $('#m'+tmp_id_for_chk.substring(1)).click(); } else { $('#m'+tmp_id_for_chk.substring(1)).click(); $('#m'+tmp_id_for_chk.substring(1)).click(); }
                                                    if (!$('#s'+tmp_id_for_chk.substring(1)).hasClass('active')) { $('#s'+tmp_id_for_chk.substring(1)).click(); } else { $('#s'+tmp_id_for_chk.substring(1)).click(); $('#s'+tmp_id_for_chk.substring(1)).click(); }
                                                    if (!$('#i'+tmp_id_for_chk.substring(1)).hasClass('active')) { $('#i'+tmp_id_for_chk.substring(1)).click(); } else { $('#i'+tmp_id_for_chk.substring(1)).click(); $('#i'+tmp_id_for_chk.substring(1)).click(); }
                                                    if (!$('#e'+tmp_id_for_chk.substring(1)).hasClass('active')) { $('#e'+tmp_id_for_chk.substring(1)).click(); } else { $('#e'+tmp_id_for_chk.substring(1)).click(); $('#e'+tmp_id_for_chk.substring(1)).click(); }
                                                    if (!$('#r'+tmp_id_for_chk.substring(1)).hasClass('active')) { $('#r'+tmp_id_for_chk.substring(1)).click(); } else { $('#r'+tmp_id_for_chk.substring(1)).click(); $('#r'+tmp_id_for_chk.substring(1)).click(); }
                                                 }
                                                 if(!$('#l'+tmp_id_for_chk.substring(1)).hasClass('active') && !$('#'+tmp_id_for_chk).hasClass('checkbox_for_the_rights')  ) { $('#l'+tmp_id_for_chk.substring(1)).addClass('active');}

                                                 ajouter_droits_parents($(this));
                                             }

                                         });

             $('.middle-pos').children('label').on('mouseup', function(e) {
                              e.preventDefault();
                              if ($(this).hasClass('active')==true  )
                              {
                                tmp_id_for_chk=$(this).attr('id');

                                // if ($('#t'+tmp_id_for_chk.substring(1)).hasClass('active'))  { $('#t'+tmp_id_for_chk.substring(1)).click(); } else { $('#t'+tmp_id_for_chk.substring(1)).click(); $('#t'+tmp_id_for_chk.substring(1)).click(); }

                                  if ($('.'+$(this).attr('id')).length>0)
                                  {
                                          $.confirm(
                                          {
                                            title: 'Confirmation!',
                                            content: 'appliquer aux sous menus associés?',
                                            confirmButton: 'Oui',
                                            cancelButton: 'Non',
                                            animation: 'top',
                                            confirmButtonClass: 'btn-primary btn-flat',
                                            cancelButtonClass: 'btn-default btn-flat',
                                                confirm: function()
                                                {

                                                    retrait_preliminaire($('#'+tmp_id_for_chk));


                                                    $('.'+tmp_id_for_chk).each(function()
                                                     {
                                                         $(this).removeClass('active');
                                                         if($(this).hasClass('checkbox_for_all_rights'))
                                                          {
                                                             tmp_id_for_chk2=$(this).attr('id');
                                                             if ($('#a'+tmp_id_for_chk2.substring(1)).hasClass('active'))  { $('#a'+tmp_id_for_chk2.substring(1)).click(); } else { $('#a'+tmp_id_for_chk2.substring(1)).click(); $('#a'+tmp_id_for_chk.substring(1)).click(); }
                                                             if ($('#m'+tmp_id_for_chk2.substring(1)).hasClass('active'))  { $('#m'+tmp_id_for_chk2.substring(1)).click(); } else { $('#m'+tmp_id_for_chk2.substring(1)).click(); $('#m'+tmp_id_for_chk.substring(1)).click(); }
                                                             if ($('#s'+tmp_id_for_chk2.substring(1)).hasClass('active'))  { $('#s'+tmp_id_for_chk2.substring(1)).click(); } else { $('#s'+tmp_id_for_chk2.substring(1)).click(); $('#s'+tmp_id_for_chk.substring(1)).click(); }
                                                             if ($('#i'+tmp_id_for_chk2.substring(1)).hasClass('active'))  { $('#i'+tmp_id_for_chk2.substring(1)).click(); } else { $('#i'+tmp_id_for_chk2.substring(1)).click(); $('#i'+tmp_id_for_chk.substring(1)).click(); }
                                                             if ($('#e'+tmp_id_for_chk2.substring(1)).hasClass('active'))  { $('#e'+tmp_id_for_chk2.substring(1)).click(); } else { $('#e'+tmp_id_for_chk2.substring(1)).click(); $('#e'+tmp_id_for_chk.substring(1)).click(); }
                                                             if ($('#r'+tmp_id_for_chk2.substring(1)).hasClass('active'))  { $('#r'+tmp_id_for_chk2.substring(1)).click(); } else { $('#r'+tmp_id_for_chk2.substring(1)).click(); $('#r'+tmp_id_for_chk.substring(1)).click(); }
                                                             if ($('#l'+tmp_id_for_chk2.substring(1)).hasClass('active'))  { $('#l'+tmp_id_for_chk2.substring(1)).click(); } else { $('#l'+tmp_id_for_chk2.substring(1)).click(); $('#l'+tmp_id_for_chk.substring(1)).click(); }

                                                          }

                                                     });



                                                       $('.'+tmp_id_for_chk).each(function()
                                                       {
                                                          tmp_id_for_chk3=$(this).attr('id');
                                                          if ($('#t'+tmp_id_for_chk3.substring(1)).hasClass('active'))  { $('#t'+tmp_id_for_chk3.substring(1)).removeClass('active'); }
                                                       });
                                                       //a gerer
                                                       //if ($('#t'+tmp_id_for_chk.substring(1)).hasClass('active'))  { $('#t'+tmp_id_for_chk.substring(1)).removeClass('active'); }

                                                },
                                                cancel: function(){
                                                        $('#'+tmp_id_for_chk).addClass('active');
                                                    }


                                          });
                                  }
                                  else{
                                  retrait_preliminaire($('#'+tmp_id_for_chk));
                                  }
                                  //if ($('#t'+tmp_id_for_chk.substring(1)).hasClass('active'))  { $('#t'+tmp_id_for_chk.substring(1)).removeClass('active'); }

                              }
                          });

                            //setgestiondroit

                                  function retirer_droits()
                                  {
                                  $('.'+tmp_id_for_chk).each(function()
                                      {
                                          $(this).removeClass('active');
                                      });

                                      //if(!$('#l'+$('.'+tmp_id_for_chk).attr('id').substring(1)).hasClass('active'))  $('#l'+$('.'+tmp_id_for_chk).attr('id').substring(1)).click();
                                      if($(this).hasClass('checkbox_for_all_rights'))
                                      {
                                         if ($('#l'+tmp_id_for_chk.substring(1)).hasClass('active'))  { $('#l'+tmp_id_for_chk.substring(1)).click(); } else { $('#l'+tmp_id_for_chk.substring(1)).click(); $('#l'+tmp_id_for_chk.substring(1)).click(); }
                                         if ($('#a'+tmp_id_for_chk.substring(1)).hasClass('active'))  { $('#a'+tmp_id_for_chk.substring(1)).click(); } else { $('#a'+tmp_id_for_chk.substring(1)).click(); $('#a'+tmp_id_for_chk.substring(1)).click(); }
                                         if ($('#m'+tmp_id_for_chk.substring(1)).hasClass('active'))  { $('#m'+tmp_id_for_chk.substring(1)).click(); } else { $('#m'+tmp_id_for_chk.substring(1)).click(); $('#m'+tmp_id_for_chk.substring(1)).click(); }
                                         if ($('#s'+tmp_id_for_chk.substring(1)).hasClass('active'))  { $('#s'+tmp_id_for_chk.substring(1)).click(); } else { $('#s'+tmp_id_for_chk.substring(1)).click(); $('#s'+tmp_id_for_chk.substring(1)).click(); }
                                         if ($('#i'+tmp_id_for_chk.substring(1)).hasClass('active'))  { $('#i'+tmp_id_for_chk.substring(1)).click(); } else { $('#i'+tmp_id_for_chk.substring(1)).click(); $('#i'+tmp_id_for_chk.substring(1)).click(); }
                                         if ($('#e'+tmp_id_for_chk.substring(1)).hasClass('active'))  { $('#e'+tmp_id_for_chk.substring(1)).click(); } else { $('#e'+tmp_id_for_chk.substring(1)).click(); $('#e'+tmp_id_for_chk.substring(1)).click(); }
                                         if ($('#r'+tmp_id_for_chk.substring(1)).hasClass('active'))  { $('#r'+tmp_id_for_chk.substring(1)).click(); } else { $('#r'+tmp_id_for_chk.substring(1)).click(); $('#r'+tmp_id_for_chk.substring(1)).click(); }
                                      }
                                  }
                                  function retirer_droits_parents(monargument)
                                  {
                                    theclasses=$(monargument).attr('class').split(' ');
                                        for(i=0;i<theclasses.length;i++)
                                        {
                                           if ($('#'+theclasses[i]).hasClass('active')) $('#'+theclasses[i]).removeClass('active');
                                           if ($('#t'+theclasses[i].substring(1)).hasClass('active')) $('#t'+theclasses[i].substring(1)).removeClass('active');
                                           if ($('.l'+theclasses[i].substring(1)).hasClass('active')) $('#l'+theclasses[i].substring(1)).addClass('active');
                                        }
                                    }
                                  function ajouter_droits_parents(monargument)
                                  {
                                    theclasses=$(monargument).attr('class').split(' ');
                                        for(i=0;i<theclasses.length;i++)
                                        {
                                           if (!$('#l'+theclasses[i].substring(1)).hasClass('active')) $('#l'+theclasses[i].substring(1)).addClass('active');
                                        }
                                    }
                                  function retrait_preliminaire(monargument)
                                  {
                                  tmp_id_for_chk=$(monargument).attr('id');
                                  if ($('#t'+tmp_id_for_chk.substring(1)).hasClass('active') && !$(monargument).hasClass('checkbox_for_all_rights'))  { $('#t'+tmp_id_for_chk.substring(1)).removeClass('active'); }

                                   if($('#'+tmp_id_for_chk).hasClass('checkbox_for_all_rights') )
                                    {
                                       if ($('#a'+tmp_id_for_chk.substring(1)).hasClass('active'))  { $('#a'+tmp_id_for_chk.substring(1)).click(); retirer_droits_parents($('#a'+tmp_id_for_chk.substring(1))); } else { $('#a'+tmp_id_for_chk.substring(1)).click(); $('#a'+tmp_id_for_chk.substring(1)).click(); }
                                       if ($('#m'+tmp_id_for_chk.substring(1)).hasClass('active'))  { $('#m'+tmp_id_for_chk.substring(1)).click(); retirer_droits_parents($('#m'+tmp_id_for_chk.substring(1))); } else { $('#m'+tmp_id_for_chk.substring(1)).click(); $('#m'+tmp_id_for_chk.substring(1)).click(); }
                                       if ($('#s'+tmp_id_for_chk.substring(1)).hasClass('active'))  { $('#s'+tmp_id_for_chk.substring(1)).click(); retirer_droits_parents($('#s'+tmp_id_for_chk.substring(1))); } else { $('#s'+tmp_id_for_chk.substring(1)).click(); $('#s'+tmp_id_for_chk.substring(1)).click(); }
                                       if ($('#i'+tmp_id_for_chk.substring(1)).hasClass('active'))  { $('#i'+tmp_id_for_chk.substring(1)).click(); retirer_droits_parents($('#i'+tmp_id_for_chk.substring(1))); } else { $('#i'+tmp_id_for_chk.substring(1)).click(); $('#i'+tmp_id_for_chk.substring(1)).click(); }
                                       if ($('#e'+tmp_id_for_chk.substring(1)).hasClass('active'))  { $('#e'+tmp_id_for_chk.substring(1)).click(); retirer_droits_parents($('#e'+tmp_id_for_chk.substring(1))); } else { $('#e'+tmp_id_for_chk.substring(1)).click(); $('#e'+tmp_id_for_chk.substring(1)).click(); }
                                       if ($('#r'+tmp_id_for_chk.substring(1)).hasClass('active'))  { $('#r'+tmp_id_for_chk.substring(1)).click(); retirer_droits_parents($('#r'+tmp_id_for_chk.substring(1))); } else { $('#r'+tmp_id_for_chk.substring(1)).click(); $('#r'+tmp_id_for_chk.substring(1)).click(); }
                                       if ($('#l'+tmp_id_for_chk.substring(1)).hasClass('active'))  { $('#l'+tmp_id_for_chk.substring(1)).click(); retirer_droits_parents($('#l'+tmp_id_for_chk.substring(1))); } else { $('#l'+tmp_id_for_chk.substring(1)).click(); $('#l'+tmp_id_for_chk.substring(1)).click(); }

                                    }


                                    else if($('#'+tmp_id_for_chk).hasClass('checkbox_for_the_rights') )
                                     {
                                        if ($('#a'+tmp_id_for_chk.substring(1)).hasClass('active'))  { $('#a'+tmp_id_for_chk.substring(1)).removeClass('active'); $('.a'+tmp_id_for_chk.substring(1)).removeClass('active');  retirer_droits_parents($('#a'+tmp_id_for_chk.substring(1))); }
                                        if ($('#m'+tmp_id_for_chk.substring(1)).hasClass('active'))  { $('#m'+tmp_id_for_chk.substring(1)).removeClass('active'); $('.m'+tmp_id_for_chk.substring(1)).removeClass('active');  retirer_droits_parents($('#m'+tmp_id_for_chk.substring(1))); }
                                        if ($('#s'+tmp_id_for_chk.substring(1)).hasClass('active'))  { $('#s'+tmp_id_for_chk.substring(1)).removeClass('active'); $('.s'+tmp_id_for_chk.substring(1)).removeClass('active');  retirer_droits_parents($('#s'+tmp_id_for_chk.substring(1))); }
                                        if ($('#i'+tmp_id_for_chk.substring(1)).hasClass('active'))  { $('#i'+tmp_id_for_chk.substring(1)).removeClass('active'); $('.i'+tmp_id_for_chk.substring(1)).removeClass('active');  retirer_droits_parents($('#i'+tmp_id_for_chk.substring(1))); }
                                        if ($('#e'+tmp_id_for_chk.substring(1)).hasClass('active'))  { $('#e'+tmp_id_for_chk.substring(1)).removeClass('active'); $('.e'+tmp_id_for_chk.substring(1)).removeClass('active');  retirer_droits_parents($('#e'+tmp_id_for_chk.substring(1))); }
                                        if ($('#r'+tmp_id_for_chk.substring(1)).hasClass('active'))  { $('#r'+tmp_id_for_chk.substring(1)).removeClass('active'); $('.r'+tmp_id_for_chk.substring(1)).removeClass('active');  retirer_droits_parents($('#r'+tmp_id_for_chk.substring(1))); }
                                        if ($('#t'+tmp_id_for_chk.substring(1)).hasClass('active'))  { $('#t'+tmp_id_for_chk.substring(1)).removeClass('active'); $('.t'+tmp_id_for_chk.substring(1)).removeClass('active');  retirer_droits_parents($('#t'+tmp_id_for_chk.substring(1))); }

                                     }

                                    retirer_droits_parents($('#'+tmp_id_for_chk));
                                  }
                                  function mettre_a_jour_inputs()
                                  {

                                      $('.middle-pos').each( function()
                                       {
                                         $(this).removeClass('middle-pos');

                                         $(this).children('label').each(function()
                                         {
                                           if ($(this).hasClass('active')  )
                                           {
                                             //$(this).click(); $(this).click();
                                             $('#rules').val($('#rules').val()+'_'+$(this).attr('id'));
                                             // if ('l'+$(this).attr('id').substring(1)==$(this).attr('id')) $(this).click();
                                             // else $(this).click(); $(this).click();
                                           }
                                         });

                                       }).addClass('middle-pos');

                                  }
                                  function reinitialiser_a_jour_inputs()
                                  {
                                       $('.middle-pos').each( function()
                                        {
                                          $(this).removeClass('middle-pos');

                                          $(this).children('label').each(function()
                                          {
                                            if ($(this).hasClass('active'))
                                            {
                                               $(this).removeClass('active');
                                            }
                                          });

                                        }).addClass('middle-pos');
                                   }
                                  function ajouter_droits()
                                  {
                                      $('.'+tmp_id_for_chk).each(function()
                                      {
                                          $(this).addClass('active');
                                          if(!$('#l'+$(this).attr('id').substring(1)).hasClass('active'))
                                          {
                                              $('#l'+$(this).attr('id').substring(1)).addClass('active');
                                          }
                                      });

                                      //if(!$('#l'+$('.'+tmp_id_for_chk).attr('id').substring(1)).hasClass('active'))  $('#l'+$('.'+tmp_id_for_chk).attr('id').substring(1)).click();
                                      if($(this).hasClass('checkbox_for_all_rights'))
                                      {
                                         if (!$('#l'+tmp_id_for_chk.substring(1)).hasClass('active')) { $('#l'+tmp_id_for_chk.substring(1)).click(); } else { $('#l'+tmp_id_for_chk.substring(1)).click(); $('#l'+tmp_id_for_chk.substring(1)).click(); }
                                         if (!$('#a'+tmp_id_for_chk.substring(1)).hasClass('active')) { $('#a'+tmp_id_for_chk.substring(1)).click(); } else { $('#a'+tmp_id_for_chk.substring(1)).click(); $('#a'+tmp_id_for_chk.substring(1)).click(); }
                                         if (!$('#m'+tmp_id_for_chk.substring(1)).hasClass('active')) { $('#m'+tmp_id_for_chk.substring(1)).click(); } else { $('#m'+tmp_id_for_chk.substring(1)).click(); $('#m'+tmp_id_for_chk.substring(1)).click(); }
                                         if (!$('#s'+tmp_id_for_chk.substring(1)).hasClass('active')) { $('#s'+tmp_id_for_chk.substring(1)).click(); } else { $('#s'+tmp_id_for_chk.substring(1)).click(); $('#s'+tmp_id_for_chk.substring(1)).click(); }
                                         if (!$('#i'+tmp_id_for_chk.substring(1)).hasClass('active')) { $('#i'+tmp_id_for_chk.substring(1)).click(); } else { $('#i'+tmp_id_for_chk.substring(1)).click(); $('#i'+tmp_id_for_chk.substring(1)).click(); }
                                         if (!$('#e'+tmp_id_for_chk.substring(1)).hasClass('active')) { $('#e'+tmp_id_for_chk.substring(1)).click(); } else { $('#e'+tmp_id_for_chk.substring(1)).click(); $('#e'+tmp_id_for_chk.substring(1)).click(); }
                                         if (!$('#r'+tmp_id_for_chk.substring(1)).hasClass('active')) { $('#r'+tmp_id_for_chk.substring(1)).click(); } else { $('#r'+tmp_id_for_chk.substring(1)).click(); $('#r'+tmp_id_for_chk.substring(1)).click(); }
                                      }
                                      if(!$('#l'+tmp_id_for_chk.substring(1)).hasClass('active')) { $('#l'+tmp_id_for_chk.substring(1)).addClass('active'); }

                                  }
                                   //setgestiondroit





           $('.liste_opener').on('click', function(e) {
              e.preventDefault();
              list=$(this).attr('value');
              resource=$(this).attr('value');
              if(resource>0)
              {
                  setClientSession(resource);
              }
              ouvrir_liste(list);
            });



           }



           function myprompt(msg)
           {
             $.confirm({
               title: '{{trans('message.confirmation')}}!',
               content: msg,
               confirmButton: '{{trans('message.oui')}}',
               cancelButton: '{{trans('message.non')}}',
               animation: 'top',
               confirmButtonClass: 'btn-primary btn-flat',
               cancelButtonClass: 'btn-default btn-flat',
               confirm: function(){
                 return 1;
               }
             });

           }


           //ajout du 14.03.17

           function ecran(val,idvu,fichier,param){
           	var req = $.ajax({
                  url: '{{URL::to('ecran')}}',
                  type: "GET",
                  data: { val : val, fichier : fichier ,param : param },
                  dataType: "html"
                });
                afficher_chargement();
              req.done(function( msg ) {
                   $('#'+idvu).html( msg );
                   set_basic_functions();

                });
              cacher_chargement();
              $('#revenir').click();
              $('#closeselect').click(); 
              $('#chargerparrain').click();
                
           }


           function ecran2(val,idvu,fichier,param){
           	var req = $.ajax({
                  url: '{{URL::to('ecran')}}',
                  type: "GET",
                  data: { val : val, fichier : fichier ,param : param },
                  dataType: "html"
                });
                afficher_chargement();
              req.done(function( msg ) {
                   $('#'+idvu).html( $('#'+idvu).html()+ msg );
                   set_basic_functions();
                });

              cacher_chargement();
           }

           set_basic_functions();


         </script>