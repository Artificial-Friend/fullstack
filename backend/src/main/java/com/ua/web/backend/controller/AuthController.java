package com.ua.web.backend.controller;

import com.ua.web.backend.config.security.UserAuthProvider;
import com.ua.web.backend.mapper.UserMapper;
import com.ua.web.backend.model.dto.CredentialsDto;
import com.ua.web.backend.model.dto.SignUpDto;
import com.ua.web.backend.model.dto.UserDto;
import com.ua.web.backend.model.entity.User;
import com.ua.web.backend.service.UserService;
import lombok.RequiredArgsConstructor;
import org.springframework.http.ResponseEntity;
import org.springframework.security.core.annotation.AuthenticationPrincipal;
import org.springframework.security.core.userdetails.UserDetails;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.PostMapping;
import org.springframework.web.bind.annotation.RequestBody;
import org.springframework.web.bind.annotation.RestController;

import java.net.URI;

@RequiredArgsConstructor
@RestController
public class AuthController {

    private final UserService userService;
    private final UserAuthProvider userAuthProvider;
    private final UserMapper userMapper;

    @PostMapping("/login")
    public ResponseEntity<UserDto> login(@RequestBody CredentialsDto credentialsDto) {
        try {
            UserDto user = userService.login(credentialsDto);
            user.setToken(userAuthProvider.createToken(user.getLogin()));
            return ResponseEntity.ok(user);
        } catch (RuntimeException e) {
            return ResponseEntity.notFound().build();
        }
    }

    @PostMapping("/register")
    public ResponseEntity<UserDto> register(@RequestBody SignUpDto signUpDto) {
        UserDto user = userService.register(signUpDto);
        user.setToken(userAuthProvider.createToken(user.getLogin()));
        return ResponseEntity.created(URI.create("/users/" + user.getId())).body(user);
    }

    @PostMapping("/logout")
    public ResponseEntity<UserDto> logout(@RequestBody CredentialsDto credentialsDto) {
        UserDto user = userService.login(credentialsDto);
        user.setToken(null);
        return ResponseEntity.ok(user);
    }

    @GetMapping("/v1/user-data")
    public ResponseEntity<UserDto> getUserData(@AuthenticationPrincipal UserDetails userDetails) {
        User user = (User) userDetails;
        return ResponseEntity.ok(userMapper.toUserDto(user));
    }
}
