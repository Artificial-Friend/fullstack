package com.ua.web.backend.controller;

import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.RestController;

import java.time.LocalDateTime;
import java.time.format.DateTimeFormatter;
import java.util.Arrays;
import java.util.List;

@RestController
public class MessageController {
    private int counter = 0;

    @GetMapping("/messages")
    public ResponseEntity<List<String>> getMessage() {
        LocalDateTime now = LocalDateTime.now();
        DateTimeFormatter formatter = DateTimeFormatter.ofPattern("yyyy-MM-dd HH:mm:ss");
        String timeNow = now.format(formatter);
        String count = String.valueOf(++counter);
        return ResponseEntity.ok(Arrays.asList(timeNow, count));
    }
}
