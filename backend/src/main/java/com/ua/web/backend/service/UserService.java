package com.ua.web.backend.service;

import com.ua.web.backend.model.dto.CredentialsDto;
import com.ua.web.backend.model.dto.SignUpDto;
import com.ua.web.backend.model.dto.UserDto;
import com.ua.web.backend.model.entity.User;
import com.ua.web.backend.exception.AppException;
import com.ua.web.backend.mapper.UserMapper;
import com.ua.web.backend.repository.UserRepository;
import lombok.RequiredArgsConstructor;
import org.springframework.http.HttpStatus;
import org.springframework.security.crypto.password.PasswordEncoder;
import org.springframework.stereotype.Service;

import java.nio.CharBuffer;
import java.util.Map;
import java.util.Optional;
import java.util.stream.Collectors;

@RequiredArgsConstructor
@Service
public class UserService {

    private final UserRepository userRepository;
    private final UserMapper userMapper;
    private final PasswordEncoder passwordEncoder;

    public UserDto findByLogin(String login) {
        return userMapper.toUserDto(findUserByLogin(login));
    }

    public User findUserByLogin(String login) {
        return userRepository.findByLogin(login)
                .orElseThrow(() -> new AppException("Unknown user", HttpStatus.NOT_FOUND));
    }

    public UserDto login(CredentialsDto credentialsDto) {
        User user = findUserByLogin(credentialsDto.getLogin());

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

    public Map<String, UserDto> exportAllUsers() {
        return userRepository.findAll().stream().collect(
                Collectors.toMap(User::getLogin, userMapper::toUserDto));
    }
}
