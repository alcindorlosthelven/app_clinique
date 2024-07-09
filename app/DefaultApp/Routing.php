<?php
use app\DefaultApp\DefaultApp as App;

App::get("/logout",function(){
   session_destroy();
   App::redirection("connexion");
},'logout');

App::get("/login", "login.login", "connexion");
App::get("/dashboard", "default.index",'dashboard');
App::get("/", "default.index", "index");
App::post("/", "default.index","index_post");
App::get("/imagerie", "default.imagerie","imagerie");
App::post("/imagerie", "default.imagerie","imagerie");
App::get("/lister-categorie-examens-imagerie", "default.listerCategorieExamensImagerie","lister_categorie_examens_imagerie");
App::get("/lister-imagerie", "default.listerImagerie","lister_imagerie");
App::get("/pos", "default.pos","pos");


App::get("/acces-utilisateur-:id", "utilisateur.acces", "acces_utilisateur")->avec("id",'[0-9]+');
App::get("/utilisateur", "utilisateur.lister","utilisateur");
App::get("/ajouter-utilisateur", "utilisateur.ajouter", "ajouter_utilisateur");
App::post("/ajouter-utilisateur", "utilisateur.ajouter","ajouter_utilisateur");
App::get("/lister-utilisateur", "utilisateur.lister", "lister_utilisateur");
App::get("/blocker-utilisateur-:id", "utilisateur.blocker", "blocker_utilisateur")->avec("id", "['0-9']+");
App::get("/deblocker-utilisateur-:id", "utilisateur.deblocker", "deblocker_utilisateur")->avec("id", "['0-9']+");
App::get("/supprimer-utilisateur-:id", "utilisateur.supprimer", "supprimer_utilisateur")->avec("id", "['0-9']+");
App::get("/modifier-utilisateur-:id", "utilisateur.modifier", "modifier_utilisateur")->avec("id", "['0-9']+");
App::post("/modifier-utilisateur-:id", "utilisateur.modifier")->avec("id", "['0-9']+");
App::get("/groupe-acces-utilisateur", "utilisateur.groupeAcces", "groupe_acces_utilisateur");
App::get("/configuration-systeme", "utilisateur.configuration", "configuration_systeme");
App::get("/compte-vendeur", "vendeur.compte", "compte_vendeur");
App::get("/demmande-elimination", "default.demmandeElimination", "demmande_elimination");

//API
App::get("api/telecharger", "default.telecharger");
App::post("api/save-token-client","default.saveTokenClient","save_token_client");
App::post("api/save-token-vendeur","default.saveTokenVendeur","save_token_vendeur");

//login logout
App::post("api/login","default.login");
App::post("api/login-2","default.login2");
App::post("api/login-3","default.login3");


App::post("api/registration","default.registration");
App::post("api/registration2","default.registration2");
App::post("api/update-password","default.updatePassword");
App::post("api/logout","default.logout");

//fin login logout
//code jeux
App::post("api/code-jeux","codeJeux.add");
App::put("api/code-jeux","codeJeux.update");
App::get("api/code-jeux/:id","codeJeux.get")->avec("id","[0-9]+");
App::get("api/code-jeux","codeJeux.gets");
App::delete("api/code-jeux/:id","codeJeux.delete")->avec("id","[0-9]+");
//fin code jeux autre lien


//client
App::post("api/client-vwazen-existe","default.clientVwazenExiste");
App::post("api/client","client.add");
App::put("api/client","client.update");
App::get("api/client/:id","client.get")->avec("id","[0-9]+");
App::get("api/client","client.gets");
App::delete("api/client/:id","client.delete")->avec("id","[0-9]+");
App::get("api/client/default","client.getDefaultClient");
App::get("api/client/total","client.total");
//fin client


//vendeur
App::post("api/vendeur","vendeur.add");
App::put("api/vendeur","vendeur.update");
App::get("api/vendeur/:id","vendeur.get")->avec("id","[0-9]+");
App::get("api/vendeur","vendeur.gets");
App::delete("api/vendeur/:id","vendeur.delete")->avec("id","[0-9]+");
App::get("api/vendeur/total","vendeur.total");

App::get("ajouter-vendeur","vendeur.ajouter","ajouter_vendeur");
App::get("lister-vendeur","vendeur.lister","lister_vendeur");
App::get("modifier-vendeur-:id","vendeur.modifier","modifier_vendeur")->avec("id","[0-9]+");
App::get("supprimer-vendeur-:id", "vendeur.supprimer", "supprimer_vendeur")->avec("id", "[0-9]+");
//fin vendeur

//vente
App::post("api/vente-lotto-max","vente.addLottoMax");
App::post("api/vente-mega","vente.addMega");
App::post("api/vente-649","vente.add649");

App::post("api/vente-powerball","vente.addPowerball");

App::post("api/paiement-vente","vente.paiementVente");
App::post("api/vente-stock","vente.addStock");
App::post("api/vente-keno","vente.addKeno");

App::get("api/vente-keno","vente.getsKenno");

App::post("api/vente","vente.add");
App::post("api/vente-2","vente.add2");

App::put("api/vente","vente.update");
App::get("api/vente/:id","vente.get")->avec("id","[0-9]+");
App::get("api/vente","vente.gets");
App::get("api/vente-stock","vente.getsStock");
App::post("api/eliminer-vente","vente.eliminer");
App::post("api/vente/confirmerElimination","vente.confimerElimination");
App::get("api/vente/par-pos-:imei","vente.getVenteParPos")->avec("imei","[0-9a-z\-]+");

App::get("api/vente/par-ticket-:ticket","vente.getParTicket")->avec("ticket","[0-9a-z\-]+");

App::get("api/vente/get-motif-elimination","vente.getMotifElimination");
App::post("api/vente/add-motif-elimination","vente.addMotifElimination");
App::put("api/vente/update-motif-elimination","vente.updateMotifElimination");
App::delete("api/vente/delete-motif/:id","vente.deleteMotif")->avec("id","[0-9]+");
App::put("api/payer-ticket/:id","vente.payerTicket")->avec("id","[0-9]+");
App::get("api/vente/total-vente","vente.totalVente");
App::get("api/vente/total-fiche-eliminer","vente.totalFicheEliminer");
App::get("api/vente-vendeur-date-tirage","vente.getVenteVendeurDateTirage");
App::get("api/vente-vendeur-date","vente.getVenteVendeurDate");
App::get("api/liste-paris-par-date","vente.listeParisParDate");
App::get("api/rapport-vente-vendeur","vente.getRapportVendeur");
App::get("api/rapport-vente-vendeur-stock","vente.getRapportVendeurStock");
App::get("api/transaction-vendeur","vente.getTransactionVendeur");

App::get("liste-vente","vente.lister","lister_vente");
App::post("liste-vente","vente.lister","lister_vente");
App::get("fiche-:id","vente.single","single_fiche")->avec("id","[0-9]+");
App::get("vente-par-pos","vente.venteParPos");
App::post("vente-par-pos","vente.venteParPos");
App::get("vente-par-pari","vente.venteParPari");
App::post("vente-par-pari","vente.venteParPari");
//App::get("fermeture-vente","vente.fermetureVente");

//fin vente

//Tirage
App::post("api/tirage","tirage.add");
App::put("api/tirage","tirage.update");
App::get("api/tirage/:id","tirage.get")->avec("id","[0-9]+");
App::get("api/tirage","tirage.gets");
App::delete("api/tirage/:id","tirage.delete")->avec("id","[0-9]+");
App::get("api/fermer-tirage","tirage.fermer");

App::post("api/fermer-imediatement/:id","tirage.fermerImediatement")->avec("id","[0-9]+");
App::post("api/programmer-fermeture/:id","tirage.programmerFermeture")->avec("id","[0-9]+");
//fin Tirage

//Tirage
App::post("api/utilisateur","utilisateur.add");
App::put("api/utilisateur","utilisateur.update");
App::get("api/utilisateur/:id","utilisateur.get")->avec("id","[0-9]+");
App::get("api/utilisateur","utilisateur.gets");
App::delete("api/utilisateur/:id","utilisateur.delete")->avec("id","[0-9]+");
App::get("api/utilisateur/total","utilisateur.total");
App::get("api/utilisateur/superviseur","utilisateur.getsSuperviseur");
//fin Tirage

//lot gagnants
App::post("api/lot-gagnant","lotGagnant.add");
App::put("api/lot-gagnant","lotGagnant.update");
App::get("api/lot-gagnant/:id","lotGagnant.get")->avec("id","[0-9]+");
App::get("api/lot-gagnant","lotGagnant.gets");
App::get("api/lot-gagnant-date-tirage","lotGagnant.getParDateTirage");
App::delete("lot-gagnant/:id","lotGagnant.delete")->avec("id","[0-9]+");
App::get("api/get-billet-gagnant","lotGagnant.getBilletGagnant");
App::get("api/get-billet-gagnant-payer","lotGagnant.getBilletGagnantPayer");
App::get("api/get-billet-gagnant-tout","lotGagnant.getBilletGagnantTout");
App::get("api/get-lot-gagnant-from-magayo-midi","lotGagnant.getLotGagnantFromMagayoMidi");

//fin lot gagnants

//pos
App::put("api/pos/update-position","pos.updatePosition");
App::post("api/pos","pos.add");
App::put("api/pos","pos.update");
App::get("api/pos/:id","pos.get")->avec("id","[0-9]+");
App::get("api/pos","pos.gets");
App::delete("api/pos/:id","pos.delete")->avec("id","[0-9]+");
App::post("api/pos/activer-:id","pos.activer")->avec("id","[0-9]+");
App::post("api/pos/desactiver-:id","pos.desactiver")->avec("id","[0-9]+");
App::post("api/pos/fermer-:id","pos.fermer")->avec("id","[0-9]+");
//pos

//banque
App::post("api/banque","banque.add");
App::put("api/banque","banque.update");
App::get("api/banque/:id","banque.get")->avec("id","[0-9]+");
App::get("api/banque","banque.gets");
App::delete("api/banque/:id","banque.delete")->avec("id","[0-9]+");
//banque

//branche
App::post("api/branche","branche.add");
App::put("api/branche","branche.update");
App::get("api/branche/:id","branche.get")->avec("id","[0-9]+");
App::get("api/branche","branche.gets");
App::delete("api/branche/:id","branche.delete")->avec("id","[0-9]+");
//branche

//lotterie
App::post("api/lotterie","lotterie.add");
App::put("api/lotterie","lotterie.update");
App::get("api/lotterie/:id","lotterie.get")->avec("id","[0-9]+");
App::get("api/lotterie","lotterie.gets");
App::delete("api/lotterie/:id","lotterie.delete")->avec("id","[0-9]+");
//lotterie

//departement
App::post("api/departement","departement.add");
App::put("api/departement","departement.update");
App::get("api/departement/:id","departement.get")->avec("id","[0-9]+");
App::get("api/departement","departement.gets");
App::delete("api/departement/:id","departement.delete")->avec("id","[0-9]+");
App::get("api/departement-par-groupe/:id","departement.getsDepartementParGroupe")->avec("id","[0-9]+");
//departement

//posVendeur
App::post("api/pos-vendeur","posVendeur.add");
App::put("api/pos-vendeur","posVendeur.update");
App::get("api/pos-vendeur/:id","posVendeur.get")->avec("id","[0-9]+");
App::get("api/pos-vendeur","posVendeur.gets");
App::delete("api/pos-vendeur/:id","posVendeur.delete")->avec("id","[0-9]+");
//posVendeur

//reseau globale
App::post("api/reseau-globale","reseauGlobale.add");
App::put("api/reseau-globale","reseauGlobale.update");
App::get("api/reseau-globale/:id","reseauGlobale.get")->avec("id","[0-9]+");
App::get("api/reseau-globale","reseauGlobale.gets");
App::delete("api/reseau-globale/:id","reseauGlobale.delete")->avec("id","[0-9]+");
//reseau globale

//groupe
App::post("api/groupe","groupe.add");
App::put("api/groupe","groupe.update");
App::get("api/groupe/:id","groupe.get")->avec("id","[0-9]+");
App::get("api/groupe","groupe.gets");
App::delete("api/groupe/:id","groupe.delete")->avec("id","[0-9]+");
App::get("api/groupe-par-reseau/:id","groupe.getsGroupeParReseau")->avec("id","[0-9]+");
//groupe

//reseau
App::post("api/reseau","reseau.add");
App::put("api/reseau","reseau.update");
App::get("api/reseau/:id","reseau.get")->avec("id","[0-9]+");
App::get("api/reseau-par-branche/:id","reseau.getsReseauParBranche")->avec("id","[0-9]+");
App::get("api/reseau","reseau.gets");
App::delete("api/reseau/:id","reseau.delete")->avec("id","[0-9]+");
//reseau

//pos
App::get("ajouter-pos","pos.ajouter","ajouter_pos");
App::get("lister-pos","pos.lister","lister_pos");
App::post("lister-pos","pos.lister","lister_pos");
App::get("modifier-pos-:id","pos.modifier","modifier_pos")->avec("id","[0-9]+");
App::get("supprimer-pos-:id","pos.supprimer","supprimer_pos")->avec("id","[0-9]+");
//pos


//rapport
App::post("rapport-vente","rapport.rapportVente");
App::get("rapport-vente","rapport.rapportVente");
App::post("rapport-vente-2","rapport.rapportVenteDeux");
App::get("rapport-vente-2","rapport.rapportVenteDeux");
App::get("rapport-fiche-vendu","rapport.ficheVendu","fiche_vendu");
App::post("rapport-fiche-vendu","rapport.ficheVendu","fiche_vendu");

App::get("rapport-fiche-gagnant","rapport.ficheGagnant","fiche_gagnant");
App::post("rapport-fiche-gagnant","rapport.ficheGagnant","fiche_gagnant");

App::get("rapport-fiche-eliminer","rapport.ficheEliminer","fiche_eliminer");
App::post("rapport-fiche-eliminer","rapport.ficheEliminer","fiche_eliminer");
//rapport

//departement
App::get("ajouter-departement","departement.ajouter","ajouter_departement");
App::get("lister-departement","departement.lister","lister_departement");
App::get("modifier-departement-:id","departement.modifier","modifier_departement")->avec("id","[0-9]+");
App::get("supprimer-departement-:id","departement.supprimer","supprimer_departement")->avec("id","[0-9]+");
//departement

//arrondissement
App::get("ajouter-arrondissement","arrondissement.ajouter","ajouter_arrondissement");
App::get("lister-arrondissement","arrondissement.lister","lister_arrondissement");
App::get("modifier-arrondissement-:id","arrondissement.modifier","modifier_arrondissement")->avec("id","[0-9]+");
App::get("supprimer-arrondissement-:id","arrondissement.supprimer","supprimer_arrondissement")->avec("id","[0-9]+");
//arrondissement

//commune
App::get("ajouter-commune","commune.ajouter","ajouter_commune");
App::get("lister-commune","commune.lister","lister_commune");
App::get("modifier-commune-:id","commune.modifier","modifier_commune")->avec("id","[0-9]+");
App::get("supprimer-commune-:id","commune.supprimer","supprimer_commune")->avec("id","[0-9]+");
//commune

//succursal
App::get("succursal","succursal.lister","lister_succursal");
App::get("ajouter-succursal","succursal.ajouter","ajouter_succursal");
App::get("lister-succursal","succursal.lister","lister_succursal");
App::get("modifier-succursal-:id","succursal.modifier","modifier_succursal")->avec("id","[0-9]+");
App::get("supprimer-succursal-:id","succursal.supprimer","supprimer_succursal")->avec("id","[0-9]+");
//succursal

//prime
App::get("lister-prime","prime.lister","lister_prime");
App::get("modifier-prime-:id","prime.modifier","modifier_prime")->avec("id","[0-9]+");
//prime

//motif elimination
App::get("ajouter-motif","motif.ajouter","ajouter_motif");
App::get("lister-motif","motif.lister","lister_motif");
App::get("modifier-motif-:id","motif.modifier","modifier_motif")->avec("id","[0-9]+");
App::get("supprimer-motif-:id","motif.supprimer","supprimer_motif")->avec("id","[0-9]+");
//motif elimination


//tirage
App::get("ajouter-tirage","tirage.ajouter","ajouter_tirage");
App::get("lister-tirage","tirage.lister","lister_tirage");
App::get("modifier-tirage-:id","tirage.modifier","modifier_tirage")->avec("id","[0-9]+");
App::get("supprimer-tirage-:id","tirage.supprimer","supprimer_tirage")->avec("id","[0-9]+");
//tirage

//log gagnant
App::get("ajouter-lotGagnant","lotGagnant.ajouter","ajouter_lotGagnant");
App::get("lister-lotGagnant","lotGagnant.lister","lister_lotGagnant");
App::post("lister-lotGagnant","lotGagnant.lister","lister_lotGagnant");
App::get("modifier-lotGagnant-:id","lotGagnant.modifier","modifier_lotGagnant")->avec("id","[0-9]+");
App::get("supprimer-lotGagnant-:id","lotGagnant.supprimer","supprimer_lotGagnant")->avec("id","[0-9]+");
//lot gagnant

App::get("tracabilite","default.tracabilite","tracabilite");
App::post("tracabilite","default.tracabilite","tracabilite");

App::get("boule-bloquer","default.bouleBloquer","boule_bloquer");
App::post("boule-bloquer","default.bouleBloquer","boule_bloquer");

App::get("statistique","default.statistique","statistique");
App::post("statistique","default.statistique","statistique");
App::get("limite-vente","default.limite","statistique");

//bank
App::get("ajouter-bank","bank.ajouter","ajouter_bank");
App::get("bank","bank.lister","lister_bank");
App::get("modifier-bank-:id","bank.modifier","modifier_bank")->avec("id","[0-9]+");
App::get("supprimer-bank-:id","bank.supprimer","supprimer_bank")->avec("id","[0-9]+");
App::get("detaille-bank-:id","bank.detaille","detaille_bank")->avec("id","[0-9]+");
App::post("detaille-bank-:id","bank.detaille","detaille_bank")->avec("id","[0-9]+");
//bank

//banque
App::get("api/info-bank-:id","default.infoBank")->avec("id","[0-9]+");
App::get('api/getbanks','default.listeBank');
//banque
App::get("api/info-client-:id","default.infoClient")->avec("id","[0-9\+]+");
App::get("api/info-client2-:id","default.infoClient2")->avec("id","[0-9\+]+");
App::post("api/transfert","default.transfert","transfert");
App::post("api/transfert-balance-credit","default.transfertBalanceCredit","transfert");
App::get("api/historique-transaction-:id","default.historiqueTransaction")->avec("id","[0-9]+");

App::get("cash","cash.index","cash");
App::post("cash","cash.index","cash");
App::get("pariaj","pariaj.index","pariaj");

App::get("api/info-vendeur-:id","default.infoVendeur")->avec("id","[0-9\+]+");
App::post("api/transfert-vendeur","default.transfertVendeur","transfert_vendeur");
App::post("api/transfert-vendeur-client","default.transfertVendeurClient","transfert_vendeur_client");
App::get("api/historique-transaction-vendeur-:id","default.historiqueTransactionVendeur")->avec("id","[0-9]+");
App::post("api/depot-client","default.DepotClient","depot_client");

App::post("api/send-sms","default.sendSms","send_sms");

App::get("api/rapport-vendeur-cash-:id","default.rapportVendeurCash")->avec("id","[0-9]+");

App::get("api/rapport-fiche-gagnant","vente.getRapportFicheGagnant");

App::post("api/redirect-moncash","default.getRedirectMoncash","redirect_moncash");
App::post("api/redirect-moncash-transfert","default.getRedirectMoncashTransfert","redirect_moncash_transfert");
App::post("api/moncash-transfert","default.moncashTransfert","redirect_moncash_transfert");

App::get("api/data-serveur-:id","default.dataServeur","data_serveur")->avec("id","[0-9]+");
App::get("api/heure","default.heure","h");

App::post("api/nyc-midi","default.nycMidi","");
App::post("api/nyc-soir","default.nycSoir","");
App::post("api/nyc-midi-modifier","default.nycMidiModifier","");
App::post("api/nyc-soir-modifier","default.nycSoirModifier","");

App::post("api/fld-midi","default.fldMidi","");
App::post("api/fld-soir","default.fldSoir","");
App::post("api/fld-midi-modifier","default.fldMidiModifier","");
App::post("api/fld-soir-modifier","default.fldSoirModifier","");

App::post("api/nj-midi","default.njMidi","");
App::post("api/nj-soir","default.njSoir","");
App::post("api/nj-midi-modifier","default.njMidiModifier","");
App::post("api/nj-soir-modifier","default.njSoirModifier","");

App::post("api/tns-midi","default.tnsMidi","");
App::post("api/tns-soir","default.tnsSoir","");
App::post("api/tns-midi-modifier","default.tnsMidiModifier","");
App::post("api/tns-soir-modifier","default.tnsSoirModifier","");


App::post("api/giorgia-midi","default.giorgiaMidi","");
App::post("api/giorgia-soir","default.giorgiaSoir","");
App::post("api/giorgia-midi-modifier","default.giorgiaMidiModifier","");
App::post("api/giorgia-soir-modifier","default.giorgiaSoirModifier","");

App::post("api/giorgia-nuit","default.giorgiaNuit","");
App::post("api/giorgia-nuit-modifier","default.giorgiaNuitModifier","");

App::post("api/texas","default.texas","");
App::post("api/texas-midi","default.texasMidi","");
App::post("api/texas-soir","default.texasSoir","");
App::post("api/texas-nuit","default.texasNuit","");

App::post("api/texas-modifier","default.texasModifier","");
App::post("api/texas-midi-modifier","default.texasMidiModifier","");
App::post("api/texas-soir-modifier","default.texasSoirModifier","");
App::post("api/texas-nuit-modifier","default.texasNuitModifier","");



App::post("api/megamillions","default.megaMillions","");
App::post("api/pick10nyc","default.pick10nyc","");

App::post("api/lottomax","default.lottomax","");
App::post("api/lotto649","default.lotto649","");

App::get("last-result","default.lastResult");

App::get("api/historique-gain-:id","default.historiqueGain")->avec("id","[0-9]+");
App::get("api/total-gain-:id","default.totalGain")->avec("id","[0-9]+");

//stock
App::get("/stock", "stock.index","stock");
App::get("/nouveau-item", "stock.ajouter","nouveau_item");
App::get("/liste-item", "stock.index","liste_item");
App::get("/modifier-item-:id", "stock.modifier", "modifier_item")->avec("id", "['0-9']+");
App::post("/modifier-item-:id", "stock.modifier", "modifier_item")->avec("id", "['0-9']+");
App::get("/historique-item-:id", "stock.historiqueItem", "historique_item")->avec("id", "['0-9']+");
App::get("/repartition-item-:id", "stock.repartition", "repartition_item")->avec("id", "['0-9']+");
App::get("/repartition-item", "stock.repartition", "repartition_item");
App::get("/transfert-item", "stock.transfert", "transfert_item");
App::get("/retirer-item", "stock.retirer", "retirer_item");
App::get("/bon-utilisation", "stock.bonUtilisation", "bon_utilisation");
App::get("/inventory", "stock.inventaire", "inventaire");
App::get("/historique", "stock.historique", "historique");
//fin stock
App::get("api/items","default.items");
App::get("/liste-vente-stock", "stock.listeVente", "lister_vente");
App::post("/liste-vente-stock", "stock.listeVente", "lister_vente");
App::get("/rapport-vente-stock", "stock.rapport", "raport_vente_stock");
App::post("/rapport-vente-stock", "stock.rapport", "raport_vente_stock");
App::get("/facture-vente-:id", "stock.factureVente","facture_vente")->avec("id",'[0-9]+');
App::get("numero-gagnant","lotGagnant.listerNumero");
App::post("numero-gagnant","lotGagnant.listerNumero");
App::get("rapport-journalier","lotGagnant.rapport");
App::post("api/clear-cache","default.clearCache");
App::get("lot-disponible","lotGagnant.lotDisponible");

App::post("update-password", "default.updatePassword", "updatePassword");
App::get("api/tirage-disponible-:id","default.tirageDisponible","tirage_disponible")->avec("id",'[0-9]+');
App::get("api/send-sms","default.sendSmsGet");
App::post("api/update-password","default.updatePassword");

App::get("api/client-par-reference","default.clientParReference");
App::get("api/rapport-par-reference","default.rapportParReference");
App::get("api/fiche-par-reference","default.ficheParReference");
App::get("api/check-imei","default.checkImei");
App::get("api/check-device-id","default.checkDeviceId");
App::get("api/get-info-ticket","default.getInfoTicket");
App::get("api/check-ticket","default.checkTicket");
App::get("api/last-result","default.apiLastResult");
App::get("api/all-result","default.apiAllResult");
App::get("api/traitement","default.apiTraitement");

App::get("api/get-prix-powerball","default.apiGetPrixPowerBall");
App::get("api/get-list-serveur","default.apiGetListeServeur");

App::get("api/get-date-controle","default.apiGetDateControle");

App::get("/facturation", "facturation.index", "facturation");
App::post("/facturation", "facturation.index", "facturation");

App::get("/doleance", "default.doleance", "doleance");
App::get("/keno", "keno.index", "keno");
//App::get("/sport", "sport.index", "sport");
App::get("/live", "sport.live", 'live');
App::get("/sport", "sport.sport", 'sport');
App::post("/keno", "keno.index", 'kenno');
App::get("/horse", "sport.horse", 'horse');

App::get("/depots", "paris.depot", 'depots');
App::post("/depots", "paris.depot", 'depots');
App::get("/retrait", "paris.retrait", 'retrait');
App::post("/retrait", "paris.retrait", 'retrait');

App::post("api/keno-result","default.kenoResult","");

App::get("api/generer-resultat-keno","default.genererResultatKeno","");
App::get("api/gtrk","default.getResultatKeno","");
App::get("api/liste-message","default.getListeMessage","");


App::get("api/resultat-keno","default.resultatKeno","");

App::get("api/keno-rules","default.kenoRules","");

App::get("/mes-paris", "paris.mesParis", 'mes_paris');
App::post("/mes-paris", "paris.mesParis", 'mes_paris');


App::get("api/get-result-match","default.getResultMatch","");
App::get("api/get-transaction-moncash-detail","default.getMoncashTransaction","");
App::get("api/get-rapport-total","default.rapportTotal","");

App::get("api/get-liste-vente","default.getListeVente","");
App::get("api/update-liste-vente","default.updateListeVente","");
App::get("api/get-liste-entreprise","default.getListeEntreprise","");
App::get("api/get-liste-reference","default.getListeReference","");
App::get("api/get-liste-sreference","default.getListeSReference","");

//ROUTING API TPS300 ET 8210
App::get("api/8210/serveurs","new8210Tps.serveurs");
App::post("api/8210/login","new8210Tps.login");
App::get("api/8210/tirage","new8210Tps.tirage");
App::get("api/8210/tirage-disponible","new8210Tps.tirageDisponible");
App::post("api/8210/vente","vente.add");
App::get("api/8210/vente/par-ticket-:ticket","vente.getParTicket")->avec("ticket","[0-9a-z\-]+");
App::get("api/8210/vente","vente.gets8210");
App::get("api/8210/eliminer-vente","vente.eliminer");
App::post("api/8210/eliminer-vente","vente.eliminer");
App::get("api/8210/rapport-vente-vendeur","vente.getRapportVendeur");
App::get("api/8210/rapport-fiche-gagnant","vente.getRapportFicheGagnant");
App::get("api/8210/all-result","default.apiAllResult");
App::get("api/8210/liste-message","default.getListeMessage","");
App::get("api/8210/fiche-eliminer","new8210Tps.ficheEliminer","");
App::get("api/fiche-eliminer","new8210Tps.ficheEliminer","");
App::get("api/8210/transaction-vendeur","vente.getTransactionVendeur");
App::get("api/8210/telecharger", "default.telecharger");
App::get("api/8210/payer-ticket","vente.payerTicket1")->avec("id","[0-9]+");





