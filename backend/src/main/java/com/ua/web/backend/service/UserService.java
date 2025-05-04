package com.ua.web.backend.service;

import com.ua.web.backend.dto.CredentialsDto;
import com.ua.web.backend.dto.SignUpDto;
import com.ua.web.backend.dto.UserDto;
import com.ua.web.backend.entity.User;
import com.ua.web.backend.exception.AppException;
import com.ua.web.backend.mapper.UserMapper;
import com.ua.web.backend.repository.UserRepository;
import lombok.RequiredArgsConstructor;
import org.springframework.http.HttpStatus;
import org.springframework.security.crypto.password.PasswordEncoder;
import org.springframework.stereotype.Service;

import java.nio.CharBuffer;
import java.util.Optional;

@RequiredArgsConstructor
@Service
public class UserService {

    private final UserRepository userRepository;
    private final UserMapper userMapper;
    private final PasswordEncoder passwordEncoder;

    public UserDto findByLogin(String login) {
        User user = userRepository.findByLogin(login)
                .orElseThrow(() -> new AppException("Unknown user", HttpStatus.NOT_FOUND));
        return userMapper.toUserDto(user);
    }

    public UserDto login(CredentialsDto credentialsDto) {
        User user = userRepository.findByLogin(credentialsDto.getLogin())
                .orElseThrow(() -> new AppException("Unknown user", HttpStatus.NOT_FOUND));

            if (passwordEncoder.matches(CharBuffer.wrap(credentialsDto.getPassword()), user.getPassword())) {
                return userMapper.toUserDto(user);
            }

            throw new AppException("Invalid credentials", HttpStatus.UNAUTHORIZED);
    }

    public UserDto register(SignUpDto dto) {

        Optional<User> optionalUser = userRepository.findByLogin(dto.getLogin());

        if (optionalUser.isPresent()) {
            throw new AppException("User already exists", HttpStatus.CONFLICT);
        }

        User user = userMapper.signUpDtoToUser(dto);

        user.setPassword(passwordEncoder.encode(CharBuffer.wrap(dto.getPassword())));

        User savedUser = userRepository.save(user);

        return userMapper.toUserDto(savedUser);
    }
}
