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

## Search
   

Note: due to my current lack of knowledge about ES6 transpilers and limited time available i had to write the React code within an inline script in default.ctp. I understand this is bad practice and would have not done so if i had more time, however all of the components have been put in separate .js files for documentation and readability purposes.  

Path to all js files: benchsci_testapp/app/webroot/js/

Path to the html file being used: benchsci_testapp/app/View/Layouts/deafult.ctp
