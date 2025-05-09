package com.ua.web.backend.controller;

import com.ua.web.backend.model.dto.UserDto;
import com.ua.web.backend.service.UserService;
import lombok.RequiredArgsConstructor;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.RestController;

import java.util.Collection;

@RequiredArgsConstructor
@RestController
public class UserspaceController {

    private final UserService userService;

    @GetMapping("/v1/admin")
    public ResponseEntity<Object> adminData() {
        return ResponseEntity.ok().build();
    }

    @GetMapping("/v1/user")
    public ResponseEntity<Object> userData() {
        return ResponseEntity.ok().build();
    }

    @GetMapping("/v1/dashboard")
    public ResponseEntity<Collection<UserDto>> dashboardData() {
        Collection<UserDto> values = userService.exportAllUsers().values();
        return ResponseEntity.ok(values);
    }
}

