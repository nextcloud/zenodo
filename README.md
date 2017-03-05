[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/nextcloud/zenodo/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/nextcloud/zenodo/?branch=master)

Based on files_zenodo from Lars Naesbye Christensen, DeIC for ownCloud - https://github.com/deic-dk/files_zenodo

# Publish your work on Zenodo.org

![example screenshot](screenshots/dialogpopup.png)

Zenodo helps your users sharing and managing their research work using Zenodo.org data repository.

## Dependencies 
 * nextcloud 10 (tested on nc12)

## Installation instructions
Copy the app files to the **nextcloud/apps/** directory.
In the Admin Interface, fill the data with the tokens from Zenodo.org (Sandbox and/or Production token).

## Usage
From the Files App, your users now have the possibility to create a Deposition from the File Action Menu. The creation of a new deposition is done in a dialog popup, asking for details about the Deposition and a list of Author/Creator of the uploaded document. If the Orcid App is installed, and the target user updated their Orcid data in the Personal Interface, adding a user to the Authors list will directly add its ORCID to the Zenodo form. 

Users can also add/upload files/documents to an existing Deposition, using the File Action Menu. Upload of new file to an already created Deposition is limited to the owner of the Deposition (the user who created the Deposition).



