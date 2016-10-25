# benchsci_testapp


# Functionality Overview:



  -list all research papers that match the search in the the search input - if input is empty all papers are listed
  
  -bookmark papers by clicking on the star at the top right of the paper display
  
  -view bookmarked papers at the top of the screen, note:container is scrollable when there are more than three bookmarks scroll down on the container to view them
  
  -display the number of bookmarked papers the user has
  
  -display a bar graph of research technique groups relevant to the search
  
  -display full paper information on a separate page - click paper tite link to do so




  
  
# Components:


              
      PaperListView:
          -PaperListView
             -BookmarkedPapersContainer 
                 -PaperList 
             -SearchForm
             -BarGraph
             -PaperList 
             -LoadMoreListItemsButton 

      PaperList:
          -PaperList
             -PaperShorthand

      PaperShorthand:
          -PaperShorthand
             -BookmarkToggle

      LoadMoreListItemsButton:
          -LoadMoreListItemsButton

      BookmarkToggle:
          -BookmarkToggle

      PaperFull:
          -PaperFull

      BarGraph:
          -BarGraph

      SearchForm:
          -Search Form

      PaperFull
          -PaperFull
                   
                   



# Implementation

All functionality is built with one way data flow and composability in mind. Top level components contain all of the state and provide callbacks to modify the satate to the child components, in both PaperListView and PaperFull. 

### Search:
   Search is initiated by the SearchForm component which calls a PaperListView callback function to retrieve the results. Once the results are recieved the state is changed and PaperListView renders the new results. The query is limited to 20 results per call to avoid loading unnecessary data. The user is provided with a more button at the end of the current query display. The callback for this button queries the server with the same gene value as the initial search and also includes an offset in order to retrieve only the next 20 results and not any of the previous results already displayed. If there are no matching results or no more results to load the appropriate message is displayed.
   
### Favourites Rendering:
   
   Favourites Countainer
   
   
   Initiated onComponentDidMount in PaperListView makes an ajax call to retrieve all of the favourites. Favourites container is then initiaded with data returned. This component takes advantage of composabilty by using the same PaperList component as the search display.
   
   Favourites Toggle
     
   Initiated by the BookmarkToggle this functionality either deletes or adds a favourite. The BookmarkToggle component takes in an id of the paper it is to modify, the callback to modify it and a boolean that indicates if the paper is in favourites. These values are assigned by the PaperList by comparing a papers id to a list of favourites id's that is passed to PaperList as a prop. 
   
### Full Paper View
   Takes in url parameter id, makes an ajax call to the server to retrieve the full paper data with appropriat id.
   
### Bar Graph   
   
   Takes a set of key value pairs as a dat prop. Renders svg based on data. Call to retrieve graph data is made by PaperListView every time a new search is complete. Adjusts bar height for display purposes if there are less than 3 bars to display. 
   
   
   
# Aditional Information:

Note: due to my current lack of knowledge about ES6 transpilers and limited time available i had to write the React code within an inline script in default.ctp. I understand this is bad practice and would have not done so if i had more time, however all of the components have been put in separate .js files for documentation and readability purposes.  

Path to all js files: benchsci_testapp/app/webroot/js/

Path to the html file being used: benchsci_testapp/app/View/Layouts/deafult.ctp
