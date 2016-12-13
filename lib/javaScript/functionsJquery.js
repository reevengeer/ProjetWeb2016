
$(document).ready(function()
{
   $("#suppressionTexte").click(function() 
   {
        $( "#cookies" ).empty();
   });
   
   $("#imageDeconnexion").ready(function() 
   {
        $( "#imageDeconnexion" ).remove();
   });
   
   $("#imageAjoutDVD").click(function() 
   {
        $( "#imageAjoutDVD" ).remove();
   });
   
    $("#IdentifiantAvecSouvenir").blur(function() 
    {
        IdentifiantAvecSouvenir = $("#IdentifiantAvecSouvenir").val();
        
        if($.trim(IdentifiantAvecSouvenir) !='')
        {
            recherche = "login="+IdentifiantAvecSouvenir;
            $.ajax(
            {
                type: 'GET',
                data: recherche,
                dataType: "json",
                url: './lib/php/ajax/AjaxFonctions.php',
                success: function(data) 
                { //data = ce qui revient du script PHP
                    $("#password").val(data[0].password); //on compléte le champ password                
                }
                
            })
        }
    });
    
});
