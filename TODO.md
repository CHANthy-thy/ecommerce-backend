# Backend TODO

- [x] Update AuthController@updateProfile to support profile image upload (validated image) and/or image_url.
- [x] Save uploaded file path or URL into users.profile_image.
- [x] Delete old local profile image from storage when replaced by a new upload.
- [x] Update User model fillable to include profile_image.
- [ ] Quick manual test: PUT /profile with multipart/form-data image.
- [ ] Quick manual test: PUT /profile with JSON image_url.


